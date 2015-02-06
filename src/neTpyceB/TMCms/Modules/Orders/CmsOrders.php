<?
namespace neTpyceB\TMCms\Modules\Orders;

use neTpyceB\TMCms\HTML\Cms\CmsForm;
use neTpyceB\TMCms\HTML\Cms\CmsTable;
use neTpyceB\TMCms\HTML\Cms\Column\ColumnAccept;
use neTpyceB\TMCms\HTML\Cms\Column\ColumnData;
use neTpyceB\TMCms\HTML\Cms\Column\ColumnDelete;
use neTpyceB\TMCms\HTML\Cms\Column\ColumnEdit;
use neTpyceB\TMCms\HTML\Cms\Element\CmsHtml;
use neTpyceB\TMCms\HTML\Cms\Element\CmsRow;
use neTpyceB\TMCms\Modules\Catalogue\Object\Product;
use neTpyceB\TMCms\Modules\Orders\Object\Order;
use neTpyceB\TMCms\Modules\Orders\Object\OrderItem;
use neTpyceB\TMCms\Modules\Orders\Object\OrderItemCollection;
use neTpyceB\TMCms\Strings\Converter;

defined('INC') or exit;


class CmsOrders
{

    /** Main view */
    public function _default() {
        echo CmsTable::getInstance()
            ->addDataSql('
SELECT
`o`.`id`,
`o`.`date_created`,
`o`.`name`,
`o`.`sum`,
`o`.`phone`,
`o`.`email`,
`o`.`done`,
`o`.`company`
FROM `'. ModuleOrders::$tables['orders'] .'` AS `o`
ORDER BY `o`.`date_created` DESC
    ')
            ->addColumn(ColumnEdit::getInstance('id')->title('Nr.')->enableOrderableColumn()->href('?p='. P .'&do=view&id={%id%}'))
            ->addColumn(ColumnData::getInstance('name')->enableOrderableColumn())
            ->addColumn(ColumnData::getInstance('phone')->enableOrderableColumn())
            ->addColumn(ColumnData::getInstance('email')->enableOrderableColumn()->dataType('email'))
            ->addColumn(ColumnData::getInstance('company')->enableOrderableColumn())
            ->addColumn(ColumnData::getInstance('sum')->enableOrderableColumn()->sumTotal(true)->nowrap(true)->width('1%')->align('right'))
            ->addColumn(ColumnData::getInstance('date_created')->nowrap(true)->align('right')->dataType('ts2datetime')->title('Date')->enableOrderableColumn())
            ->addColumn(ColumnAccept::getInstance('done')->href('?p='. P .'&do=_done&id={%id%}')->enableOrderableColumn())
            ->addColumn(ColumnDelete::getInstance()->href('?p='. P .'&do=_delete&id={%id%}'))
        ;
    }


    /** View one */
    public function view() {
        if (!isset($_GET['id']) || !ctype_digit((string)$_GET['id'])) return;
        $order_id = $_GET['id'];

        $order = new Order($order_id);
        if (!$order) return;

        $items_collection = new OrderItemCollection;
        $items_collection->setWhereOrderId($order->getId());
        $items_collection->clearCollectionCache();

        $order_data = $order->getAsArray();

        $form = CmsForm::getInstance()
            ->outputTagForm(false)
        ;

        $order_data['date_created'] = date(CFG_CMS_DATETIME_FORMAT, $order_data['date_created']);
        $order_data['Nr.'] = $order_data['id'];

        unset($order_data['id']);
        unset($order_data['client_id']);

        foreach ($order_data as $k => $item) {
            if (!is_string($item)) continue;

            $form->addField(Converter::symb2Ttl($k), CmsHtml::getInstance($k)->value(htmlspecialchars($item, ENT_QUOTES)));
        }

        $form->addField('<br>', CmsRow::getInstance('')->value('<br>'));

        $order_items = $items_collection->getAsArrayOfObjects();
        foreach ($order_items as $item) {
            /** @var OrderItem $item */
            $data = $item->getSavedItemData();

            $form->addField(
                Converter::symb2Ttl($data['multi_lng_data']['title'][LNG]),
                CmsHtml::getInstance('item_' . $item->getId())->value(
                    htmlspecialchars('ID: '. $item->getId() . ' - Sum: ' .$item->getAmount() .' * '. ($data['price_special'] > 0 ? $data['price_special'] : $data['price']) . ' = ' . ($item->getAmount() * $data['price_special'] > 0 ? $data['price_special'] : $data['price']) , ENT_QUOTES)
                ));
        }

        echo $form;
    }

    public function _done() {
        if (!isset($_GET['id']) || !ctype_digit((string)$_GET['id'])) return;
        $order_id = $_GET['id'];

        $order = new Order($order_id);
        $order->flipBoolValue('done');
        $order->save();

        back();
    }

    public function _delete() {

        if (!isset($_GET['id']) || !ctype_digit((string)$_GET['id'])) return;
        $order_id = $_GET['id'];

        $order = new Order($order_id);
        $order->deleteObject();

        back();
    }
}