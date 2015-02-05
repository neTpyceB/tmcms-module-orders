<?php
namespace neTpyceB\TMCms\Modules\Params\Object;

use neTpyceB\TMCms\Modules\CommonObject;


class Parameter extends CommonObject {
    protected $db_table = 'm_params';
    protected $multi_lng_fields = ['title'];

    protected $title = '';
    protected $type = '';
    protected $active = false;
}