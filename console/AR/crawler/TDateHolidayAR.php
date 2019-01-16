<?php
/**
 * Created by PhpStorm.
 * User: jiuzheyang
 * Date: 2019/1/16
 * Time: 下午2:44
 */

namespace console\AR\crawler;


use common\models\crawler\TDateHoliday;

class TDateHolidayAR extends TDateHoliday
{
    /**
     * 检查日期是否重复，重复则修改，否则保存
     *
     * @author      刘富胜 2019-1-16
     * @param array $params 保存的参数
     * @return boolean 返回类型
     */
    public function saveDateInfo($params)
    {
        $tDateHoliday = static::findOne(['date' => trim($params['date'])]);
        if (empty($tDateHoliday)){
            $tDateHoliday = new TDateHoliday();
        }

        $column=array_keys($tDateHoliday->getAttributes());
        unset($params['id']);
        foreach ($params as $k => $v) {
            if(!in_array($k,$column)) continue;
            $tDateHoliday[$k] = trim($v);
        }
        if (!$tDateHoliday->save()){
            \Yii::info($tDateHoliday->getErrorsToString(), 'test');
        }
        return $tDateHoliday->save();

    }
}