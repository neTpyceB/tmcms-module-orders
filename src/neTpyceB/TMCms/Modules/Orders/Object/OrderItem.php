<?php
namespace neTpyceB\TMCms\Modules\Orders\Object;

use neTpyceB\TMCms\Modules\CommonObject;


/**
 * Class OrderItem
 * @package neTpyceB\TMCms\Modules\Orders\Object
 * @method getAmount() string
 * @method setAmount(int)
 */
class OrderItem extends CommonObject {
    protected $db_table = 'm_orders_items';

    protected $order_id = 0;
    protected $item_type = '';
    protected $item_id = 0;
    protected $amount = 0;
    protected $saved_item_data = 0;

    /**
     * @param int $order_id
     * @return $this
     */
    public function setOrderId($order_id)
    {
        $this->setField('order_id', $order_id);

        return $this;
    }

    /**
     * @param string $item_type
     * @return $this
     */
    public function setItemType($item_type)
    {
        $this->setField('item_type', $item_type);

        return $this;
    }

    /**
     * @param int $item_id
     * @return $this
     */
    public function setItemId($item_id)
    {
        $this->setField('item_id', $item_id);

        return $this;
    }

    /**
     * @param CommonObject $item
     * @return $this
     */
    public function setItem(CommonObject $item)
    {
        $this->setItemId($item->getId());
        $this->setItemData($item->getAsArray());

        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setItemData(array $data) {
        $this->setField('saved_item_data', serialize($data));

        return $this;
    }

    /**
     * @return array
     */
    public function getSavedItemData()
    {
        return unserialize($this->getField('saved_item_data'));
    }
}