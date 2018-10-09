<?php

namespace common\models;

use yii\db\ActiveRecord;
use common\helpers\GenerateHelper;
use yii\db\Exception;

abstract class ARBase extends ActiveRecord
{
    protected $issetId = true;
    /**
     * 判断是否存在某个列
     * @param string $colName
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    private function hasColumn($colName)
    {
        $schema = static::getTableSchema();
        return array_key_exists($colName, $schema->columns);
    }

    /**
     * 初始化某一列的默认值
     * @param string $colName 数据库列名
     * @param string $defaultValue 默认值
     */
    private function initColumn($colName, $defaultValue)
    {
        if ($this->hasColumn($colName) && empty($this->$colName)) {
            $this->$colName = $defaultValue;
        }
    }

    /**
     * @param bool $insert
     * @return bool
     */
//    public function beforeSave($insert)
//    {
//        if ($insert && $this->issetId) {
//            $this->initColumn('id', GenerateHelper::uuid());
//        }
//        return parent::beforeSave($insert);
//    }

    /**
     * 批量插入
     * @param array $rows the rows to be batch inserted into the table
     * @return int
     * @throws \yii\db\Exception
     */
    public function dataBatchInsert(array $rows = [])
    {
        if (!$rows) {
            return 0;
        }
        $columns = array_keys($rows[0]);
        return static::getDb()->createCommand()->batchInsert(static::tableName(), $columns, $rows)->execute();
    }

    /**
     * 批量更新插入
     * @param array $rows
     * @return int
     * @throws \yii\db\Exception
     */
    public function dataBatchReplaceInsert(array $rows = [])
    {
        if (!$rows) {
            return 0;
        }
        $columns = array_keys($rows[0]);
        $sql = static::getDb()->getQueryBuilder()->batchInsert(static::tableName(), $columns, $rows);
        $sql = 'REPLACE' . mb_substr($sql, 6, null, 'utf8');
        return static::getDb()->createCommand($sql)->execute();
    }

    /**
     * 批量更新（使用UPDATE，可以只更新部分字段）
     * @author evan   <laizhenggang@inboyu.com>
     * @param  array  $rows
     * @param  string $primaryKey 作为更新条件的字段名，必须是PRIMARY KEY
     * @throws \Exception
     * @return int
     */
    public function dataBatchUpdate($rows = [], $primaryKey)
    {
        $tableName = static::tableName();
        if (!$rows || !is_array($rows)) throw new \Exception('第一个参数不能为空，且必须是数组');

        $columns = array_keys($rows[0]);
        if(empty($columns))  throw new \Exception('第一个参数必须是一个二维数组');

        if(empty(static::isPrimaryKey([$primaryKey]))) throw new \Exception('"'.$primaryKey.'"不是表"'.$tableName.'"的PRIMARY KEY');
        if(!in_array($primaryKey, $columns)) throw new \Exception('没有找到key为"'.$primaryKey.'"的数组成员');

        $derivativeTableName = 'derivative_table';

        $setFields = '';
        $derivativeTableFields = '"__" AS '.implode(', "__" AS ', $columns); // 类似SELECT value AS field，所以生成的派生表第一行的每个字段值都是"___"
        $derivativeTableValues = '';

        // 生成字段名
        foreach ($columns as $v) {
            if(empty($this->hasColumn($v))) throw new \Exception('"'.$v.'"不是表"'.$tableName.'"中的字段');
            $setFields .= "{$tableName}.{$v} = {$derivativeTableName}.{$v},";
        }
        // 去掉最后一个逗号
        $setFields = substr($setFields, 0, strlen($setFields)-1);

        // 生成字段值
        foreach ($rows as $k => $v) {
            foreach ($v as &$vv) {
                $vv = '\''.addslashes($vv).'\'';
            }
            $derivativeTableValues .= 'UNION ALL SELECT '.implode(', ', $v)." \n";
        }

        // 目前使用SELECT...UNION ALL SELECT...产生派生表，再通过set table.field = derivative.field的方式更新数据
        // 可以改成使用临时表实现，提高性能
        $sql = <<<SQL
                    UPDATE {$tableName},
                            (
                              SELECT {$derivativeTableFields}
                                {$derivativeTableValues}
                            ) AS {$derivativeTableName}
                    SET
                      {$setFields}
                    WHERE {$tableName}.{$primaryKey} = {$derivativeTableName}.{$primaryKey}
SQL;

        return static::getDb()->createCommand($sql)->execute();
    }

    /**
     * 获取所以错误信息
     * @return string
     */
    public function getErrorsToString()
    {
        $arr = [];
        foreach ($this->getErrors() as $error) {
            foreach ($error as $item) {
                $arr[] = $item;
            }
        }
        if ($arr) {
            return implode(' ', $arr);
        }
        return '';
    }

    /**
     * @return string
     */
    public function getFirstErrorsToString()
    {
        $arr = $this->getFirstErrors();
        if (empty($arr)) {
            return '';
        }
        $arr = array_values($arr);
        return $arr[0];
    }

}
