<?php

namespace common\models\order;

use Yii;

/**
 * This is the model class for table "lfs_with_author".
 *
 * @property int $id
 * @property string $author_name 作者名称
 * @property int $create_time 创建时间
 * @property int $modify_time 修改时间
 * @property int $create_by 创建者id
 * @property int $modify_by 修改者id
 * @property int $is_delete 是否删除标识
 */
class LfsWithAuthor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lfs_with_author';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_time', 'modify_time', 'create_by', 'modify_by', 'is_delete'], 'integer'],
            [['author_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_name' => 'Author Name',
            'create_time' => 'Create Time',
            'modify_time' => 'Modify Time',
            'create_by' => 'Create By',
            'modify_by' => 'Modify By',
            'is_delete' => 'Is Delete',
        ];
    }
}
