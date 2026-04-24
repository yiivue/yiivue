<?php

return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    'JWT_SECRET' => getenv('JWT_SECRET') ?: 'yiivue-dev-jwt-secret-change-this-to-a-long-random-string-2026',
    'JWT_EXPIRE' => (int) (getenv('JWT_EXPIRE') ?: 86400),
    'jwt' => [
        'issuer' => 'yiivue-yii2-api',
        'audience' => 'yiivue-vue-client',
        'id' => 'yiivue-access-token',
        'expire' => '+' . (getenv('JWT_EXPIRE') ?: 86400) . ' seconds',
        'request_time' => '+0 seconds',
        'algorithm' => 'HS256',
    ],
];
