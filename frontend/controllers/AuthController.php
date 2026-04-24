<?php

namespace frontend\controllers;

use DateTimeImmutable;
use Yii;
use yii\rest\Controller;
use yii\web\Response;
use common\models\User;
use yii\filters\Cors;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;

class AuthController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;

        if (isset($behaviors['authenticator'])) {
            unset($behaviors['authenticator']);
        }

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => false,
                'Access-Control-Max-Age' => 86400,
            ],
        ];

        $behaviors['authenticator'] = [
            'class' => \kaabar\jwt\JwtHttpBearerAuth::class,
            'except' => ['login', 'register', 'options'],
        ];

        return $behaviors;
    }

    public function actionLogin()
    {
        $data = $this->getRequestData();

        $email = trim((string) ($data['email'] ?? ''));
        $password = (string) ($data['password'] ?? '');

        if (!$email || !$password) {
            throw new BadRequestHttpException('Email and password are required.');
        }

        $user = User::findByEmail($email);
        if (!$user || !$user->validatePassword($password)) {
            throw new UnauthorizedHttpException('Invalid credentials.');
        }

        return $this->buildAuthResponse($user);
    }

    public function actionRegister()
    {
        $data = $this->getRequestData();

        $email = trim((string) ($data['email'] ?? ''));
        $password = (string) ($data['password'] ?? '');
        $username = trim((string) ($data['username'] ?? $data['name'] ?? ''));

        if ($username === '') {
            $username = strstr($email, '@', true) ?: $email;
        }

        if (!$email || !$password) {
            throw new BadRequestHttpException('Email and password are required.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new BadRequestHttpException('Please provide a valid email address.');
        }

        if (mb_strlen($password) < (int) Yii::$app->params['user.passwordMinLength']) {
            throw new BadRequestHttpException('Password is too short.');
        }

        if (User::find()->where(['email' => $email])->exists()) {
            throw new BadRequestHttpException('Email already registered.');
        }

        if (User::find()->where(['username' => $username])->exists()) {
            throw new BadRequestHttpException('Username already registered.');
        }

        $user = new User();
        $user->email = $email;
        $user->username = $username;
        $user->setPassword($password);
        $user->generateAuthKey();

        if ($user->hasAttribute('confirmed_at')) {
            $user->confirmed_at = time();
        }

        if ($user->hasAttribute('registration_ip')) {
            $user->registration_ip = Yii::$app->request->userIP;
        }

        if (!$user->save()) {
            throw new BadRequestHttpException('Unable to register user.');
        }

        return $this->buildAuthResponse($user);
    }

    public function actionLogout()
    {
        return ['success' => true];
    }

    private function getRequestData(): array
    {
        $data = Yii::$app->request->getBodyParams();

        if (is_array($data) && $data !== []) {
            return $data;
        }

        $decoded = json_decode(Yii::$app->request->getRawBody(), true);

        return is_array($decoded) ? $decoded : [];
    }

    private function buildAuthResponse(User $user): array
    {
        return [
            'success' => true,
            'access_token' => $this->generateAccessToken($user),
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'username' => $user->username,
            ],
            'expires_in' => (int) Yii::$app->params['JWT_EXPIRE'],
        ];
    }

    private function generateAccessToken(User $user): string
    {
        $jwt = Yii::$app->jwt;
        $jwtParams = Yii::$app->params['jwt'];
        $now = new DateTimeImmutable();

        $token = $jwt->getBuilder()
            ->issuedBy($jwtParams['issuer'])
            ->permittedFor($jwtParams['audience'])
            ->identifiedBy($jwtParams['id'], true)
            ->issuedAt($now)
            ->canOnlyBeUsedAfter($now->modify($jwtParams['request_time']))
            ->expiresAt($now->modify($jwtParams['expire']))
            ->withClaim('uid', (int) $user->id)
            ->getToken(
                $jwt->getSigner($jwtParams['algorithm']),
                $jwt->getKey()
            );

        return $token->toString();
    }
}
