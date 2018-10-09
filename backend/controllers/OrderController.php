<?php
/**
 * Created by PhpStorm.
 * User: jiuzheyang
 * Date: 2018/9/30
 * Time: 下午4:57
 */

namespace backend\controllers;


use common\models\order\LfsWithOrder;
use yii\web\Controller;
use yii\web\Response;

class OrderController extends Controller
{
    public function actionTest()
    {
        return $this->json(get_class());
    }
    protected function json($data) {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return $data;
    }
}