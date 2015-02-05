<?php
namespace neTpyceB\TMCms\Modules\Orders\Object;

use neTpyceB\TMCms\Modules\CommonObject;


class OrderItem extends CommonObject {
    protected $db_table = 'm_orders_items';

    protected $order_id = 0;
    protected $item_type = '';
    protected $item_id = 0;
    protected $amount = 0;
    protected $saved_item_data = 0;
}