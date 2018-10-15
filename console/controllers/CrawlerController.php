<?php
/**
 * 抓取邮箱
 *
 * @author      刘富胜 2018-10-09
 * @version     1.0 版本号
 */

namespace console\controllers;

use console\business\crawler\TeacherEmailBusiness;

class CrawlerController extends ControllerBase
{
    public $enableCsrfValidation = false;

    private $_teacherEmailBusiness;

    public function __construct($id, $module, TeacherEmailBusiness $teacherEmailBusiness,$config = array())
    {
       $this->_teacherEmailBusiness = $teacherEmailBusiness;
        parent::__construct($id, $module, $config);
    }

    /**
     * 天津工业大学纺织学院
     *
     * @author      刘富胜 2018-10-09
     * @return string 返回类型
     */
    public function actionTeacherMail_tjpu()
    {
        try{
            ignore_user_abort(true);
            set_time_limit(0);//忽略页面执行超时
            print_r($this->_teacherEmailBusiness->getTeacherMail_tjpu());
        }catch (\Exception $e){
            \Yii::info($e->getTraceAsString(), 'crawler');
            var_dump($e->getMessage());
        }
    }

    /**
     * 研究生导师查询系统
     *
     * @author      刘富胜 2018-10-09
     * @return string 返回类型
     */
    public function actionTeacherMail_daoshieol()
    {
        try{
            ignore_user_abort(true);
            set_time_limit(0);//忽略页面执行超时
            print_r($this->_teacherEmailBusiness->getTeacherMail_daoshieol());
        }catch (\Exception $e){
            \Yii::info($e->getTraceAsString(), 'crawler');
            var_dump($e->getMessage());
        }
    }

    /**
     * 扬州大学建筑科学与工程学院
     *
     * @author      刘富胜 2018-10-09
     * @return string 返回类型
     */
    public function actionTeacherMail_jgxyyzu()
    {
        try{
            ignore_user_abort(true);
            set_time_limit(0);//忽略页面执行超时
            print_r($this->_teacherEmailBusiness->getTeacherMail_jgxyyzu());
        }catch (\Exception $e){
            \Yii::info($e->getTraceAsString(), 'crawler');
            var_dump($e->getMessage());
        }
    }

    /**
     * 华南理工大学
     *
     * @author      刘富胜 2018-10-10
     * @return string 返回类型
     */
    public function actionTeacherMail_yanzhaoscut()
    {
        try{
            ignore_user_abort(true);
            set_time_limit(0);//忽略页面执行超时
            print_r($this->_teacherEmailBusiness->getTeacherMail_yanzhaoscut());
        }catch (\Exception $e){
            \Yii::info($e->getTraceAsString(), 'crawler');
            var_dump($e->getMessage());
        }
    }

    /**
     * 扬州大学建筑化学化工学院
     *
     * @author      刘富胜 2018-10-15
     * @return string 返回类型
     */
    public function actionTeacherMail_hxhgyzu()
    {
        try{
            ignore_user_abort(true);
            set_time_limit(0);//忽略页面执行超时
            print_r($this->_teacherEmailBusiness->getTeacherMail_hxhgyzu());
        }catch (\Exception $e){
            \Yii::info($e->getTraceAsString(), 'crawler');
            var_dump($e->getMessage());
        }
    }

}