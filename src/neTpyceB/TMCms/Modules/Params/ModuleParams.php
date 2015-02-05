<?php
namespace neTpyceB\TMCms\Modules\Params;

use neTpyceB\TMCms\Modules\IModule;
use neTpyceB\TMCms\Modules\Rating\Object\Rating;
use neTpyceB\TMCms\Modules\Rating\Object\RatingCollection;

defined('INC') or exit;

class ModuleParams implements IModule {
	/** @var $this */
	private static $instance;

	public static function getInstance() {
		if (!self::$instance) self::$instance = new self;
		return self::$instance;
	}
}