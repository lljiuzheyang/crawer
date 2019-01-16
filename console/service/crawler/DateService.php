<?php
/**
 * Created by PhpStorm.
 * User: jiuzheyang
 * Date: 2019/1/16
 * Time: 下午2:36
 */

namespace console\service\crawler;


use console\AR\crawler\TDateHolidayAR;
use console\business\publicMethods\public_utf;

class DateService
{
    private $_TDateHolidayAR;

    public function __construct(TDateHolidayAR $TDateHolidayAR)
    {
        $this->_TDateHolidayAR = $TDateHolidayAR;
    }

    /**
     * 抓取日期信息
     * @author 刘富胜 2019-1-16
     * @param string $year 年份
     * @param string $month 月份
     * @return mixed
     */
    public function getDateInfo($year='2018',$month='1')
    {
        return $this->yearInfo($year,$month);
    }

    /**
     * 封装抓取的方法
     *
     * @author 刘富胜 2019-1-16
     *
     * @param string $year 年份
     * @param string $month 月份
     * @return mixed
     */
    public function yearInfo($year='2018',$month='1')
    {
        $url =  "https://sp0.baidu.com/8aQDcjqpAAV3otqbppnN2DJv/api.php?query={$year}年{$month}月&resource_id=6018&format=json";
        $get_utf8 = new public_utf();
        $content = $get_utf8->convert_encoding_to_utf8(public_utf::get($url));
        $params = json_decode($content,true);
        $arr = [];
        $date = $params['data'][0]['almanac'];
        foreach ($date as $v){
            $arr[$v['date']]['avoid'] = $v['avoid'];
            $arr[$v['date']]['date'] = $v['date'];
            $arr[$v['date']]['suit'] = $v['suit'];
        }
        $holiday = $params['data'][0]['holiday'];
        if (!empty($holiday[0])){
            foreach ($holiday as &$day){
                $arr[$day['festival']]['name'] = $day['name'];
                $arr[$day['festival']]['date'] = $day['festival'];
                $arr[$day['festival']]['remark'] = $day['desc'];
                $arr[$day['festival']]['rest'] = $day['rest'];
                if ($day['list']>0){
                    foreach ($day['list'] as $list){
                        $arr[$list['date']]['date']= $list['date'];
                        $arr[$list['date']]['status']= $list['status'];
                    }
                }
            }
        }else{
            $arr[$holiday['festival']]['name'] = $holiday['name'];
            $arr[$holiday['festival']]['date'] = $holiday['festival'];
            $arr[$holiday['festival']]['remark'] = $holiday['desc'];
            $arr[$holiday['festival']]['rest'] = $holiday['rest'];
            if ($holiday['list']>0){
                foreach ($holiday['list'] as $list){
                    $arr[$list['date']]['date']= $list['date'];
                    $arr[$list['date']]['status']= $list['status'];
                }
            }
        }

        return $arr;
    }

    /**
     * 批量保存日期信息
     *
     * @author      刘富胜 2018-10-09
     * @param array $list 保存的参数
     * @return int 返回类型
     */
    public function batchSave($list){
        $count = 0;
        foreach ($list as $v){
            \Yii::info($v, 'test');
            $res = $this->_TDateHolidayAR->saveDateInfo($v);
            if ($res){
                $count++;
            }
        }
        return (int)$count;
    }


}