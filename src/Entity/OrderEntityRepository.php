<?php

namespace TMCms\Modules\Orders\Entity;

use TMCms\Orm\EntityRepository;

/**
 * Class OrderEntityRepository
 * @package TMCms\Modules\Orders\Entity
 *
 * @method $this setWhereClientId(int $client_id)
 */
class OrderEntityRepository extends EntityRepository
{
    protected $table_structure = [
        'fields' => [
            'client_id' => [
                'type' => 'index'
            ],
            'delivery_id' => [
                'type' => 'index'
            ],
            'delivery_date' => [
                'type' => 'ts'
            ],
            'status' => [
                'type' => 'index'
            ],
            'number' => [
                'type' => 'varchar'
            ],
            'sum' => [
                'type' => 'float'
            ],
            'ts_issued' => [
                'type' => 'ts',
            ],
        ],
    ];
}