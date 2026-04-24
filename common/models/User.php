<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property int $created_at
 * @property int $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    public const STATUS_DELETED = 0;
    public const STATUS_INACTIVE = 9;
    public const STATUS_ACTIVE = 10;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::activeQuery()
            ->andWhere(['id' => $id])
            ->one();
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::activeQuery()
            ->andWhere(['username' => $username])
            ->one();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::hasTableColumn('password_reset_token')) {
            return null;
        }

        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
        return static::findOne(['password_reset_token' => $token]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        if (!static::hasTableColumn('verification_token')) {
            return null;
        }

        return static::findOne(['verification_token' => $token]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        if (!$this->hasAttribute('password_reset_token')) {
            return;
        }

        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        if (!$this->hasAttribute('verification_token')) {
            return;
        }

        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        if (!$this->hasAttribute('password_reset_token')) {
            return;
        }

        $this->password_reset_token = null;
    }

    // common/models/User.php

    public static function findByEmail($email)
    {
        return static::activeQuery()
            ->andWhere(['email' => $email])
            ->one();
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
        try {
            $decoded = Yii::$app->jwt->loadToken((string) $token);
            if (!is_object($decoded)) {
                return null;
            }

            $userId = $decoded->claims()->get('uid');

            return static::activeQuery()
                ->andWhere(['id' => $userId])
                ->one();
        } catch (\Throwable $e) {
            return null;
        }
    }

    private static function activeQuery()
    {
        $query = static::find();

        if (static::hasTableColumn('blocked_at')) {
            $query->andWhere(['blocked_at' => null]);
        } elseif (static::hasTableColumn('status')) {
            $query->andWhere(['status' => self::STATUS_ACTIVE]);
        }

        return $query;
    }

    private static function hasTableColumn(string $name): bool
    {
        return static::getTableSchema()->getColumn($name) !== null;
    }
}
