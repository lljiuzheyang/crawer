<?php

namespace common\models\crawler;

use Yii;

/**
 * This is the model class for table "t_date_holiday".
 *
 * @property int $id 主键
 * @property string $name 假日名称
 * @property string $date 日期
 * @property string $avoid 避免事项
 * @property string $suit 适宜事项
 * @property int $status 假日类别  1--为节假日，2--为工作日 0--表示普通（如果周六日则为休息日）
 * @property string $remark 假日名称
 * @property string $rest
 * @property int $days 放假天数
 */
class TDateHoliday extends \common\models\ARBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_date_holiday';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'required'],
            [['status', 'days'], 'integer'],
            [['date'], 'string', 'max' => 32],
            [['name'], 'string', 'max' => 20],
            [['avoid', 'suit', 'remark', 'rest'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键ID',
            'name' => '假日名称',
            'date' => '日期',
            'avoid' => '避免事项',
            'suit' => '适宜事项',
            'status' => '假日类别  1--为节假日，2--为工作日 0--表示普通（如果周六日则为休息日）',
            'remark' => '注释',
            'rest' => '建议',
            'days' => '放假天数',
        ];
    }
}
