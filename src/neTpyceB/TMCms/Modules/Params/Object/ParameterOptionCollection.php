<?php
namespace neTpyceB\TMCms\Modules\Params\Object;

use neTpyceB\TMCms\Modules\CommonObjectCollection;

class ParameterOptionCollection extends CommonObjectCollection {
    protected $db_table = 'm_params_options';

    /**
     * @param int $param_id
     * @return $this
     */
    public function setWhereParamId($param_id)
    {
        $this->setFilterValue('param_id', $param_id);

        return $this;

    }
}