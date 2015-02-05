<?php
namespace neTpyceB\TMCms\Modules\Orders;

use neTpyceB\TMCms\Modules\IModule;
use neTpyceB\TMCms\Modules\Orders\Object\Order;
use neTpyceB\TMCms\Modules\Rating\Object\Rating;
use neTpyceB\TMCms\Modules\Rating\Object\RatingCollection;

defined('INC') or exit;

class ModuleOrders implements IModule {
	/** @var $this */
	private static $instance;

	public static $tables = [
		'orders' => 'm_orders',
		'items' => 'm_orders_items'
	];

	public static function getInstance() {
		if (!self::$instance) self::$instance = new self;
		return self::$instance;
	}
}