<?php

namespace TMCms\Modules\Orders;

use TMCms\Modules\IModule;
use TMCms\Modules\Orders\Entity\OrderEntityRepository;
use TMCms\Traits\singletonInstanceTrait;

defined('INC') or exit;

class ModuleOrders implements IModule
{
    use singletonInstanceTrait;

    public static $order_statuses = [
        '10' => 'new',
        '15' => 'canceled',
        '20' => 'accepted',
        '30' => 'processing',
        '40' => 'in_stock',
        '50' => 'paid',
        '60' => 'delivering',
        '70' => 'delivered',
        '80' => 'closed',
    ];

    /**
     * @param array $params ['limit' => '3', 'client_id' => '12']
     * @return OrderEntityRepository
     */
    public static function getOrders(array $params)
    {
        $orders = new OrderEntityRepository();

        if (isset($params['limit'])) {
            $orders->setLimit(abs((int)$params['limit']));
        }

        if (isset($params['client_id'])) {
            $orders->setWhereClientId(abs((int)$params['client_id']));
        }

        $orders->addOrderByField('ts_issued', true);

        return $orders;
    }
}