<?php
/**
 * 抓取教师邮箱
 *
 * @author      刘富胜 2018-10-09
 * @version     1.0 版本号
 */


namespace console\AR\crawler;


use common\models\crawler\TeacherEmail;

class TeacherEmailAR extends TeacherEmail
{
    /**
     * 检查邮箱是否重复，重复则不保存，否则保存
     *
     * @author      刘富胜 2018-10-09
     * @param array $params 保存的参数
     * @return boolean 返回类型
     */
    public function saveTeacherInfo($params)
    {
        $teacherEmail = static::findOne(['email' => $params['email']]);
        if (!empty($teacherEmail)){
            \Yii::info($params['email'], 'crawler');
            return false;
        }
        $teacherEmail = new TeacherEmail();
        $column=array_keys($teacherEmail->getAttributes());
        unset($params['id']);
        unset($params['teacher_id']);
        foreach ($params as $k => $v) {
            if(!in_array($k,$column)) continue;
            $teacherEmail[$k] = $v;
        }
        if (!$teacherEmail->save()){
            \Yii::info($teacherEmail->getErrorsToString(), 'crawler');
        }
        return $teacherEmail->save();

    }

}