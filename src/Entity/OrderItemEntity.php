<?php
declare(strict_types=1);

namespace TMCms\Modules\Orders\Entity;

use TMCms\Orm\Entity;

/**
 * Class OrderItemEntity
 * @package TMCms\Modules\Orders\Entity
 *
 * @method $this setAdditionalProperties(string $json_additional_properties)
 * @method $this setItemAmount(float $item_amount)
 * @method $this setItemName(string $item_name)
 * @method $this setItemPrice(float $item_price)
 * @method $this setLinkedProductId(int $linked_product_id)
 * @method $this setOrderId(int $order_id)
 * @method $this setTotalPrice(float $total_price)
 * @method $this setTotalPriceTax(float $total_price_tax)
 *
 * @method string getAdditionalProperties()
 * @method float getItemAmount()
 * @method string getItemName()
 * @method float getItemPrice()
 * @method int getLinkedProductId()
 * @method int getOrderId()
 * @method float getTotalPrice()
 * @method float getTotalPriceTax()
 */
class OrderItemEntity extends Entity
{

}
