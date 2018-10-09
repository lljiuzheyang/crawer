<?php

namespace common\models\crawler;

use Yii;

/**
 * This is the model class for table "teacher_email".
 *
 * @property string $teacher_name 教师名称
 * @property string $email 邮箱
 * @property string $create_time
 * @property string $create_by
 * @property string $type 职称
 * @property string $school_name 学校名称
 * @property int $id
 * @property string $source
 */
class TeacherEmail extends \common\models\ARBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'teacher_email';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['teacher_name', 'email', 'school_name'], 'required'],
            [['create_time'], 'safe'],
            [['teacher_name', 'school_name'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 255],
            [['create_by', 'type'], 'string', 'max' => 20],
            [['source'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'teacher_name' => 'Teacher Name',
            'email' => 'Email',
            'create_time' => 'Create Time',
            'create_by' => 'Create By',
            'type' => 'Type',
            'school_name' => '学校名称',
            'source' => 'Source',
        ];
    }
}
