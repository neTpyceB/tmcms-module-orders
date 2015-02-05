<?php
namespace neTpyceB\TMCms\Modules\Params\Object;

use neTpyceB\TMCms\Modules\CommonObject;


class ParameterOption extends CommonObject {
    protected $db_table = 'm_params_options';
    protected $multi_lng_fields = ['title'];

    protected $title = '';
    protected $order = 0;
    protected $active = false;
}