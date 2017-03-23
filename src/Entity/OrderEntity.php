<?php

namespace TMCms\Modules\Orders\Entity;

use TMCms\Config\Settings;
use TMCms\Orm\Entity;

/**
 * Class OrderEntity
 * @package TMCms\Modules\Orders\Entity
 *
 * @method int getClientId()
 * @method int getComment()
 * @method int getDeliveryDate()
 * @method int getDeliveryId()
 * @method string getNumber()
 * @method string getStatus()
 * @method float getSum()
 * @method int getTsIssued()
 *
 * @method $this setClientId(int $client_id)
 * @method $this setComment(string $comment)
 * @method $this setDeliveryDate(int $date_ts)
 * @method $this setDeliveryId(int $delivery_id)
 * @method $this setNumber(string $number)
 * @method $this setStatus(string $status)
 * @method $this setSum(float $sum)
 * @method $this setTsIssued(int $ts)
 *
 * @method array getItems()
 * @method $this setItems(array $order_items)
 */
class OrderEntity extends Entity
{
    public function getDateIssued()
    {
        return date(Settings::getDefaultDateFormat(), $this->getTsIssued());
    }

    protected function beforeSave()
    {
        $this->setTsIssued(NOW);

        return $this;
    }

    protected function beforeDelete()
    {
        // Delete all items in that order

        $items = new OrderItemEntityRepository();
        $items->setWhereOrderId($this->getId());
        $items->deleteObjectCollection();

        return $this;
    }
}