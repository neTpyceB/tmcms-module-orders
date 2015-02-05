<?php
namespace neTpyceB\TMCms\Modules\Orders\Object;

use neTpyceB\TMCms\Modules\CommonObject;

/**
 * Class Order
 * @package neTpyceB\TMCms\Modules\Orders\Object
 * @method setSum(float)
 */
class Order extends CommonObject {
    protected $db_table = 'm_orders';

    protected $client_id = 0;
    protected $date_created = '';
    protected $sum = '';
    protected $name = '';
    protected $phone = '';
    protected $email = '';
    protected $pk = '';
    protected $company = '';
    protected $company_nr = '';
    protected $company_address = '';

    public function beforeCreate() {
        $this->setField('date_created', NOW);

        parent::beforeCreate();
    }

    public function deleteObject() {
        $items_collection = new OrderItemCollection();
        $items_collection->setWhereOrderId($this->getId());
        $items_collection->deleteObjectCollection();

        parent::deleteObject();
    }
}