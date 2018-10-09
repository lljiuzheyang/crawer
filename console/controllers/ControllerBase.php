<?php
/**
 * 公有controller方法
 *
 * @author      刘富胜 2018-10-09
 * @version     1.0 版本号
 */


namespace console\controllers;

use yii\web\Controller;
use yii\web\Response;

class ControllerBase extends Controller {

    public function getNewLine(){
        return '\t*\s*\r*\n*\t*\s*\r*\n*\t*\s*';
    }

    public function convert_encoding_to_utf8($content){
        if(!empty($content) && !mb_check_encoding($content, 'utf-8')) {
            $content = mb_convert_encoding($content,'UTF-8','gbk');
        }
        return $content;
    }

    public function isDebugHost(){
        $host = \Yii::$app->request->getHostInfo();

        $flag = false;
        if(strpos($host, 'demo.rendd.cn') > -1) {
            $flag = true;
        }
        if(strpos($host, 'localhost') > -1) {
            $flag = true;
        }
        if(strpos($host, '192.168.') > -1) {
            $flag = true;
        }
        if(strpos($host, '127.0.0.1') > -1) {
            $flag = true;
        }

        return $flag;
    }

    public function getSource($host){
        return '<p style="color: dimgray;font-size: 14px;">本数据为系统自动获取，如有变动请以<a target="_blank" href="'.$host.'">来源网站为准</a></p>';
    }

    protected function json($data, $result = array("code" => 1, "msg" => ""))
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $result['data'] = $data;

        \Yii::$app->response->data = $result;

        return $result;
    }

}