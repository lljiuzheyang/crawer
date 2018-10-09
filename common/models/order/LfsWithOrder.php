<?php

namespace common\models\order;

use Yii;

/**
 * This is the model class for table "lfs_with_order".
 *
 * @property int $id 主键
 * @property string $order_name 订单名称
 * @property int $customer_id 客户id
 * @property int $book_id 图书id
 * @property int $create_time 创建时间
 * @property int $modify_time 修改时间
 * @property int $is_delete 是否删除标识
 */
class LfsWithOrder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lfs_with_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'customer_id', 'book_id', 'create_time', 'modify_time', 'is_delete'], 'integer'],
            [['order_name'], 'string', 'max' => 255],
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
            'order_name' => 'Order Name',
            'customer_id' => 'Customer ID',
            'book_id' => 'Book ID',
            'create_time' => 'Create Time',
            'modify_time' => 'Modify Time',
            'is_delete' => 'Is Delete',
        ];
    }
}
