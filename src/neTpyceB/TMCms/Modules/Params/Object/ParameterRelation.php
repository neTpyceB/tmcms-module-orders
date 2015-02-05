<?php
namespace neTpyceB\TMCms\Modules\Params\Object;

use neTpyceB\TMCms\Modules\CommonObject;

class ParameterRelation extends CommonObject {
    protected $db_table = 'm_params_relations';

    protected $item_type = '';
    protected $item_id = 0;
    protected $param_id = 0;
}