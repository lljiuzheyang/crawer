<?php
/**
 * Created by PhpStorm.
 * User: jiuzheyang
 * Date: 2018/9/30
 * Time: 下午5:01
 */

namespace backend\service\order;

use common\models\order\LfsWithOrder;
use yii\db\Query;

class LfsWithCustomerService extends \common\models\order\LfsWithCustomer
{
    #region 获取客户的订单
    /** 获取客户的订单
     * @return Query
    */

    public function getOrders()
    {
        // 第一个参数为要关联的子表模型类名，
        // 第二个参数指定 通过子表的customer_id，关联主表的id字段
        return $this->hasMany(get_class(new LfsWithOrder()), ['customer_id' => 'id']);
    }
    #endregion

}