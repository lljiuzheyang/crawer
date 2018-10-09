<?php
/**
 * 抓取教师邮箱数据服务层
 *
 * @author      刘富胜 2018-10-09
 * @version     1.0 版本号
 */

namespace console\service\crawler;

use console\AR\crawler\TeacherEmailAR;

class TeacherEmailService
{
    private $_teacherEmailAR;
    public function __construct(TeacherEmailAR $teacherEmailAR)
    {
        $this->_teacherEmailAR = $teacherEmailAR;
    }

    /**
     * 批量保存老师邮箱信息
     *
     * @author      刘富胜 2018-10-09
     * @param array $list 保存的参数
     * @return int 返回类型
     */
    public function batchSave($list){
        $count = 0;
        foreach ($list as $v){
            \Yii::info($v, 'crawler');
            $res = $this->_teacherEmailAR->saveTeacherInfo($v);
            if ($res){
                $count++;
            }
        }
        return (int)$count;
    }

}