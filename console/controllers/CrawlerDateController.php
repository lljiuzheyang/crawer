<?php
/**
 * Created by PhpStorm.
 * User: jiuzheyang
 * Date: 2019/1/16
 * Time: 下午2:30
 */

namespace console\controllers;


use console\business\crawler\DateBusiness;

class CrawlerDateController extends ControllerBase
{
    public $enableCsrfValidation = false;

    private $_dateBusiness;

    public function __construct($id, $module, DateBusiness $dateBusiness, $config = array())
    {
        $this->_dateBusiness = $dateBusiness;
        parent::__construct($id, $module, $config);
    }

    /**
     * 抓取日期数据
     * @author 刘富胜
     * @return int
    */
    public function actionCrawBaiduDate()
    {
        print_r($this->_dateBusiness->getDate());
//        return $this->_dateBusiness->getDate();
    }

    /**
     * 获取日期数据
     * @author 刘富胜
     * @return int
     */
    public function actionGetBaiduDate()
    {
        print_r($this->_dateBusiness->getInfo());
//        return $this->_dateBusiness->getDate();
    }
}