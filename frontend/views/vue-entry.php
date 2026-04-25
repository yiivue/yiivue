<?php

use yii\helpers\Html;

$productionCssPath = Yii::getAlias('@frontend/web/spa/css/app.css');
$productionJsPath = Yii::getAlias('@frontend/web/spa/js/app.js');
$productionCssUrl = Yii::getAlias('@web/spa/css/app.css');
$productionJsUrl = Yii::getAlias('@web/spa/js/app.js');
$viteServerUrl = rtrim(getenv('VITE_DEV_SERVER_URL') ?: 'http://localhost:5173', '/');
$viteInternalUrl = rtrim(getenv('VITE_DEV_SERVER_INTERNAL_URL') ?: $viteServerUrl, '/');
$forceViteDevServer = filter_var(getenv('VITE_DEV_SERVER_FORCE') ?: false, FILTER_VALIDATE_BOOL);

$useViteDevServer = false;

if (YII_ENV_DEV) {
    if ($forceViteDevServer) {
        $useViteDevServer = true;
    }

    $viteServerParts = parse_url($viteInternalUrl);
    $viteHost = $viteServerParts['host'] ?? null;
    $vitePort = $viteServerParts['port'] ?? null;
    $viteScheme = ($viteServerParts['scheme'] ?? 'http') === 'https' ? 'ssl' : 'tcp';

    if (!$useViteDevServer && $viteHost && $vitePort) {
        $viteSocket = @stream_socket_client(
            sprintf('%s://%s:%d', $viteScheme, $viteHost, $vitePort),
            $errorCode,
            $errorMessage,
            0.2
        );

        if (is_resource($viteSocket)) {
            fclose($viteSocket);
            $useViteDevServer = true;
        }
    }
}

$useProductionBuild = !$useViteDevServer && is_file($productionJsPath);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>YiiVue</title>
    <?php if ($useProductionBuild && is_file($productionCssPath)): ?>
        <link rel="stylesheet" href="<?= Html::encode($productionCssUrl) ?>">
    <?php endif; ?>
</head>
<body>
    <div id="app"></div>
    <?php if ($useViteDevServer): ?>
        <script type="module" src="<?= Html::encode($viteServerUrl . '/@vite/client') ?>"></script>
        <script type="module" src="<?= Html::encode($viteServerUrl . '/frontend/resources/js/app.js') ?>"></script>
    <?php elseif ($useProductionBuild): ?>
        <script type="module" src="<?= Html::encode($productionJsUrl) ?>"></script>
    <?php else: ?>
        <div style="padding: 1rem; font-family: sans-serif;">
            Vue assets are not available. Run <code>npm run dev</code> for hot reload or <code>npm run build</code> for a production bundle.
        </div>
    <?php endif; ?>
</body>
</html>
