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

    public function __construct($id, $module, TeacherEmailBusiness $teacherEmailBusiness, $config = array())
    {
        $this->_teacherEmailBusiness = $teacherEmailBusiness;
        parent::__construct($id, $module, $config);
    }

    /**
     * 天津工业大学纺织学院
     *
     * @author      刘富胜 2018-10-09
    * @return boolean 返回类型
     */
    public function actionTeacherMail_tjpu()
    {
        try {
            ignore_user_abort(true);
            set_time_limit(0);//忽略页面执行超时
            print_r($this->_teacherEmailBusiness->getTeacherMail_tjpu());
            return true;
        } catch (\Exception $e) {
            \Yii::info($e->getTraceAsString(), 'crawler');
            var_dump($e->getMessage());
            return false;
        }
    }

    /**
     * 研究生导师查询系统
     *
     * @author      刘富胜 2018-10-09
    * @return boolean 返回类型
     */
    public function actionTeacherMail_daoshieol()
    {
        try {
            ignore_user_abort(true);
            set_time_limit(0);//忽略页面执行超时
            print_r($this->_teacherEmailBusiness->getTeacherMail_daoshieol());
            return true;
        } catch (\Exception $e) {
            \Yii::info($e->getTraceAsString(), 'crawler');
            var_dump($e->getMessage());
            return false;
        }
    }

    /**
     * 扬州大学建筑科学与工程学院
     *
     * @author      刘富胜 2018-10-09
    * @return boolean 返回类型
     */
    public function actionTeacherMail_jgxyyzu()
    {
        try {
            ignore_user_abort(true);
            set_time_limit(0);//忽略页面执行超时
            print_r($this->_teacherEmailBusiness->getTeacherMail_jgxyyzu());
            return true;
        } catch (\Exception $e) {
            \Yii::info($e->getTraceAsString(), 'crawler');
            var_dump($e->getMessage());
            return false;
        }
    }

    /**
     * 华南理工大学
     *
     * @author      刘富胜 2018-10-10
    * @return boolean 返回类型
     */
    public function actionTeacherMail_yanzhaoscut()
    {
        try {
            ignore_user_abort(true);
            set_time_limit(0);//忽略页面执行超时
            print_r($this->_teacherEmailBusiness->getTeacherMail_yanzhaoscut());
            return true;
        } catch (\Exception $e) {
            \Yii::info($e->getTraceAsString(), 'crawler');
            var_dump($e->getMessage());
            return false;
        }
    }

    /**
     * 扬州大学建筑化学化工学院
     *
     * @author      刘富胜 2018-10-15
    * @return boolean 返回类型
     */
    public function actionTeacherMail_hxhgyzu()
    {
        try {
            ignore_user_abort(true);
            set_time_limit(0);//忽略页面执行超时
            print_r($this->_teacherEmailBusiness->getTeacherMail_hxhgyzu());
            return true;
        } catch (\Exception $e) {
            \Yii::info($e->getTraceAsString(), 'crawler');
            var_dump($e->getMessage());
            return false;
        }
    }

    /**
     * 南京理工大学研究院
     *
     * @author      刘富胜 2018-10-15
    * @return boolean 返回类型
     */
    public function actionTeacherMail_nanjing_technology()
    {
        try {
            ignore_user_abort(true);
            set_time_limit(0);//忽略页面执行超时
            print_r($this->_teacherEmailBusiness->getTeacherMail_nanjing_technology());
            return true;
        } catch (\Exception $e) {
            \Yii::info($e->getTraceAsString(), 'crawler');
            var_dump($e->getMessage());
            return false;
        }
    }

    /**
     * 中国科学院沈阳自动化研究院
     *
     * @author      刘富胜 2018-10-15
    * @return boolean 返回类型
     */
    public function actionTeacherMail_sia()
    {
        try {
            ignore_user_abort(true);
            set_time_limit(0);//忽略页面执行超时
            print_r($this->_teacherEmailBusiness->getTeacherMail_sia());
            return true;
        } catch (\Exception $e) {
            \Yii::info($e->getTraceAsString(), 'crawler');
            var_dump($e->getMessage());
            return false;
        }
    }

    /**
     * 南方科技大学
     *
     * @author      刘富胜 2018-10-16
    * @return boolean 返回类型
     */
    public function actionTeacherMail_sustc()
    {
        try {
            ignore_user_abort(true);
            set_time_limit(0);//忽略页面执行超时
            print_r($this->_teacherEmailBusiness->getTeacherMail_sustc());
            return true;
        } catch (\Exception $e) {
            \Yii::info($e->getTraceAsString(), 'crawler');
            var_dump($e->getMessage());
            return false;
        }
    }

    /**
     * 中国科学院自动化研究所
     *
     * @author      刘富胜 2018-10-16
    * @return boolean 返回类型
     */
    public function actionTeacherMail_ia()
    {
        try {
            ignore_user_abort(true);
            set_time_limit(0);//忽略页面执行超时
            print_r($this->_teacherEmailBusiness->getTeacherMail_ia());
            return true;
        } catch (\Exception $e) {
            \Yii::info($e->getTraceAsString(), 'crawler');
            var_dump($e->getMessage());
            return false;
        }
    }

    /**
     * 中国科学院物理研究所
     *
     * @author      刘富胜 2018-10-16
     * @return boolean 返回类型
     */
    public function actionTeacherMail_iphy()
    {
        try {
            ignore_user_abort(true);
            set_time_limit(0);//忽略页面执行超时
            print_r($this->_teacherEmailBusiness->getTeacherMail_iphy());
            return true;
        } catch (\Exception $e) {
            \Yii::info($e->getTraceAsString(), 'crawler');
            var_dump($e->getMessage());
            return false;
        }
    }

}