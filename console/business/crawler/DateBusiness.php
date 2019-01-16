<?php
/**
 * Created by PhpStorm.
 * User: jiuzheyang
 * Date: 2019/1/16
 * Time: 下午2:31
 */

namespace console\business\crawler;


use console\service\crawler\DateService;

class DateBusiness
{
    private $_dateService;
    public function __construct(DateService $dateService)
    {
        $this->_dateService = $dateService;
    }

    /**
     * 抓取每月日期信息
     * @author 刘富胜 2019-1-16
     * @return int
     */
    public function getDate()
    {
        ini_set('user_agent', 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; GreenBrowser)');
//        $params = $this->_dateService->getDateInfo(2018,1);
        $sum = 0;
        for($i=1;$i<=12;$i++){
            $params = $this->_dateService->getDateInfo(2017,$i);
            $sum += $this->_dateService->batchSave($params);
        }
        return $sum;

    }

}