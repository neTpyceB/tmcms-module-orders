<?php
namespace neTpyceB\TMCms\Modules\Orders\Object;

use neTpyceB\TMCms\Modules\CommonObjectCollection;

class OrderItemCollection extends CommonObjectCollection {
    protected $db_table = 'm_orders_items';

    /**
     * @param int $order_id
     * @return $this
     */
    public function setWhereOrderId($order_id)
    {
        $this->setFilterValue('order_id', $order_id);

        return $this;
    }
}