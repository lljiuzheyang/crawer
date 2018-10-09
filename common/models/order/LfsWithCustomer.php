<?php

namespace common\models\order;

use Yii;

/**
 * This is the model class for table "lfs_with_customer".
 *
 * @property int $id
 * @property string $customer_name 客户名称
 * @property int $is_delete 是否删除标识
 * @property int $modify_time 修改时间
 * @property int $create_time 创建时间
 * @property int $create_by 创建者id
 * @property int $modify_by 修改者id
 */
class LfsWithCustomer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lfs_with_customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'is_delete', 'modify_time', 'create_time', 'create_by', 'modify_by'], 'integer'],
            [['customer_name'], 'string', 'max' => 50],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_name' => 'Customer Name',
            'is_delete' => 'Is Delete',
            'modify_time' => 'Modify Time',
            'create_time' => 'Create Time',
            'create_by' => 'Create By',
            'modify_by' => 'Modify By',
        ];
    }
}
