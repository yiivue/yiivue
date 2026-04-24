<?php
namespace frontend\controllers;

use yii\web\Controller;

class SpaController extends Controller
{
    public $layout = false;
    
    public function actionIndex()
    {
        return $this->renderFile('@frontend/views/vue-entry.php');
    }
}