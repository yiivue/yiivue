<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // Auth routes
                'POST api/auth/login' => 'auth/login',
                'POST api/auth/register' => 'auth/register',
                'POST api/auth/logout' => 'auth/logout',
                // API routes (keep working)
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/user'],

                // Admin routes (keep working)
                'admin/<controller>/<action>' => 'admin/<controller>/<action>',

                // Specific backend controllers you want to keep (example)
                'site/contact' => 'site/contact',
                'site/about' => 'site/about',

                // Catch-all for frontend SPA – but only if no other rule matches
                // This must be the LAST rule
                [
                    'pattern' => '<path:.*>',
                    'route' => 'spa/index',
                    'defaults' => ['path' => ''],
                ],
            ],
        ],

        'jwt' => [
            'class' => \kaabar\jwt\Jwt::class,
            'key' => $params['JWT_SECRET'],
        ],
    ],
    'params' => $params,
];
