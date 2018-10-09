<?php

namespace common\models\order;

use Yii;

/**
 * This is the model class for table "lfs_with_book".
 *
 * @property int $id
 * @property string $book_name 图书名称
 * @property int $author_id 作者id
 * @property int $is_delete 是否删除标识
 * @property int $modify_time 修改时间
 * @property int $create_time 创建时间
 */
class LfsWithBook extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lfs_with_book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'author_id', 'is_delete', 'modify_time', 'create_time'], 'integer'],
            [['book_name'], 'string', 'max' => 255],
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
            'book_name' => 'Book Name',
            'author_id' => 'Author ID',
            'is_delete' => 'Is Delete',
            'modify_time' => 'Modify Time',
            'create_time' => 'Create Time',
        ];
    }
}
