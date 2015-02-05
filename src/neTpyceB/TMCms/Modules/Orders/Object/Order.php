<?php
namespace neTpyceB\TMCms\Modules\Orders\Object;

use neTpyceB\TMCms\Modules\CommonObject;


class Order extends CommonObject {
    protected $db_table = 'm_orders';

    protected $client_id = 0;
    protected $date_created = '';
}