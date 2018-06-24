<?php
declare(strict_types=1);

namespace TMCms\Modules\Orders;

use TMCms\Modules\IModule;
use TMCms\Modules\Orders\Entity\OrderEntity;
use TMCms\Modules\Orders\Entity\OrderEntityRepository;
use TMCms\Modules\Orders\Entity\OrderItemEntityRepository;
use TMCms\Traits\singletonInstanceTrait;

\defined('INC') or exit;

/**
 * Class ModuleOrders
 * @package TMCms\Modules\Orders
 */
class ModuleOrders implements IModule
{
    use singletonInstanceTrait;

    /**
     * @param array $params ['limit' => 3, 'client_id' => 12]
     *
     * @return OrderEntityRepository
     */
    public static function getOrders(array $params): OrderEntityRepository
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

    /**
     * @param OrderEntity $order
     *
     * @return OrderItemEntityRepository
     */
    public static function getOrderItems(OrderEntity $order): OrderItemEntityRepository
    {
        $items = new OrderItemEntityRepository();
        $items->setWhereOrderId($order->getId());

        return $items;
    }
}
