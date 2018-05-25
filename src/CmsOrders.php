<?php
declare(strict_types=1);

namespace TMCms\Modules\Orders;

use TMCms\Admin\Messages;
use TMCms\DB\SQL;
use TMCms\HTML\BreadCrumbs;
use TMCms\HTML\Cms\CmsFormHelper;
use TMCms\HTML\Cms\CmsTableHelper;
use TMCms\Log\App;
use TMCms\Modules\Clients\Entity\ClientEntityRepository;
use TMCms\Modules\ModuleManager;
use TMCms\Modules\Orders\Entity\OrderEntity;
use TMCms\Modules\Orders\Entity\OrderEntityRepository;
use TMCms\Modules\Orders\Entity\OrderItemEntity;
use TMCms\Modules\Orders\Entity\OrderItemEntityRepository;

\defined('INC') or exit;

ModuleManager::requireModule('catalogue');
ModuleManager::requireModule('clients');

/**
 * Class CmsOrders
 * @package TMCms\Modules\Orders
 */
class CmsOrders
{
    /** Orders */

    public function _default()
    {
        BreadCrumbs::getInstance()
            ->addCrumb(P)
            ->addAction('Add Order', '?p=' . P . '&do=add');

        $orders = new OrderEntityRepository();
        $orders->addOrderByField('ts_issued', true);

        $clients = new ClientEntityRepository();
        $clients = $clients->getPairs('company');

        BreadCrumbs::getInstance()
            ->addCrumb(__('Orders'))
            ->addAction(__('Add Order'), '?p=' . P . '&do=add');

        echo CmsTableHelper::outputTable([
            'data' => $orders,
            'columns' => [
                'ts_issued' => [
                    'title' => 'Issue date',
                    'type' => 'datetime',
                ],
                'client_id' => [
                    'title' => 'Client',
                    'pairs' => $clients,
                ],
                'number' => [],
                'sum' => [
                    'align' => 'right',
                    'auto_sum' => true,
                ],
            ],
            'delete' => true,
            'edit' => true,
        ]);
    }

    public function edit()
    {
        $order = new OrderEntity($_GET['id']);

        BreadCrumbs::getInstance()
            ->addCrumb(__('Order'))
            ->addCrumb(__('Edit Order'))
            ->addCrumb($order->getNumber());

        echo $this->__add_edit_form($order)
            ->setButtonSubmit(__('Update'))
            ->setAction('?p=' . P . '&do=_edit&id=' . $order->getId());

        echo $this->renderJsforAddEdit();
    }

    /**
     * @param null|OrderEntity $order
     *
     * @return \TMCms\HTML\Cms\CmsForm
     */
    private function __add_edit_form($order = NULL)
    {
        if (!$order) {
            $order = new OrderEntity();
        }

        $clients = new ClientEntityRepository();
        $clients = $clients->getPairs('company');

        // Attach order items for input table
        if ($order->getId()) {
            $items = new OrderItemEntityRepository();
            $items->setWhereOrderId($order->getId());
            $order->setItems($items->getAsArrayOfObjectData(true));
        }

        return CmsFormHelper::outputForm($order->getDbTableName(), [
            'data' => $order,
            'fields' => [
                'client_id' => [
                    'title' => 'Client',
                    'options' => $clients,
                ],
                'ts_issued' => [
                    'title' => 'Issue date',
                    'type' => 'date',
                ],
                'number' => [],
                'delivery_date' => [
                    'title' => 'Delivery Date',
                    'type' => 'date',
                ],
                'items' => [
                    'title' => 'Order items',
                    'type' => 'input_table',
                    'add' => true,
                    'delete' => true,
                    'fields' => [
                        'item_name' => [
                            'title' => 'Name',
                        ],
                        'item_amount' => [
                            'title' => 'Amount',
                            'js_onchange' => 'order.calculate_row_price(this)',
                        ],
                        'item_price' => [
                            'title' => 'Price per item',
                            'js_onchange' => 'order.calculate_row_price(this)',
                        ],
                        'total_price' => [
                            'title' => 'Total price',
                        ],
                        'total_price_tax' => [],
                    ],
                ],
            ],
        ]);
    }

    /**
     * @return string
     */
    private function renderJsforAddEdit(): string
    {
        ob_start();

        ?>
        <script>
            var order = {
                calculate_row_price: function (el) {
                    var $el = $(el);
                    var id = $el.data('id');

                    var amount = $('#items_update_' + id + '_item_amount_').val();
                    var price_per_one = $('#items_update_' + id + '_item_price_').val();

                    var tax_rate = 1.21; // Be sure to have it somewhere, e.g. boot.php file ?>;
                    var total = total_vat = 0;
                    if (amount && price_per_one) {
                        total = (amount * price_per_one).toFixed(2);
                        total_vat = (total * tax_rate).toFixed(2);
                    }

                    $('#items_update_' + id + '_total_price_').val(total);
                    $('#items_update_' + id + '_total_price_tax_').val(total_vat);
                }
            };
        </script>
        <?php

        return ob_get_clean();
    }

    public function _delete()
    {
        $order = new OrderEntity($_GET['id']);
        $order->deleteObject();

        Messages::sendGreenAlert('Order deleted');
        App::add('Order ' . $order->getNumber() . ' deleted');

        if (IS_AJAX_REQUEST) {
            die('1');
        }

        back();
    }

    public function _edit()
    {
        $order = new OrderEntity($_GET['id']);
        $order->loadDataFromArray($_POST);
        $order->save();

        $items = new OrderItemEntityRepository();

        // Items
        if (isset($_POST['items'])) {
            if (isset($_POST['items']['add'])) {
                foreach ($_POST['items']['add'] as & $v) {
                    $v['order_id'] = $order->getId();
                }
            }
            SQL::storeEditableCmsTable($items->getDbTableName(), $_POST['items']);
        }

        // Update total sum
        $items->setWhereOrderId($order->getId());

        $sum = 0;
        /** @var OrderItemEntity $item */
        foreach ($items->getAsArrayOfObjects() as $item) {
            $sum += $item->getTotalPrice();
        }
        $order->setSum($sum);
        $order->save();

        Messages::sendGreenAlert('Order updated');
        App::add('Order ' . $order->getNumber() . ' updated');

        go('?p=' . P . '&highlight=' . $order->getId());
    }
}
