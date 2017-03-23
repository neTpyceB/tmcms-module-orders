<?php

namespace TMCms\Modules\Orders\Entity;

use TMCms\Orm\EntityRepository;

/**
 * Class OrderItemEntityRepository
 * @package TMCms\Modules\Orders\Entity
 *
 * @method $this setWhereOrderId(int $order_id)
 */
class OrderItemEntityRepository extends EntityRepository
{
    protected $table_structure = [
        'fields' => [
            'order_id' => [
                'type' => 'index'
            ],
            'linked_product_id' => [
                'type' => 'index'
            ],
            'item_name' => [
                'type' => 'varchar'
            ],
            'item_amount' => [
                'type' => 'float'
            ],
            'item_price' => [
                'type' => 'float'
            ],
            'total_price' => [
                'type' => 'float'
            ],
            'total_price_tax' => [
                'type' => 'float'
            ],
            'additional_properties' => [
                'type' => 'json'
            ],
        ],
    ];
}