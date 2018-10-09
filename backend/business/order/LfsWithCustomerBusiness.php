<?php
/**
 * Created by PhpStorm.
 * User: jiuzheyang
 * Date: 2018/9/30
 * Time: 下午5:18
 */

namespace backend\business\order;


use backend\service\order\LfsWithCustomerService;

class LfsWithCustomerBusiness
{
    private $_lfsWithCustomerService;

    public function __construct(LfsWithCustomerService $lfsWithCustomerService)
    {
       $this->_lfsWithCustomerService = $lfsWithCustomerService;
    }

    public function getTest(){
        $customer = LfsWithCustomerService::findOne(1);
        $orders = $customer->getOrders();
    }

}