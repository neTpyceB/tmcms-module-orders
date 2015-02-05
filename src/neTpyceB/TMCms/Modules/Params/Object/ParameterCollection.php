<?php
namespace neTpyceB\TMCms\Modules\Params\Object;

use neTpyceB\TMCms\Modules\CommonObjectCollection;

class ParameterCollection extends CommonObjectCollection {
    protected $db_table = 'm_params';

    /**
     * @param string $type
     * @return $this
     */
    public function setWhereType($type)
    {
        $this->setFilterValue('type', $type);

        return $this;

    }
}