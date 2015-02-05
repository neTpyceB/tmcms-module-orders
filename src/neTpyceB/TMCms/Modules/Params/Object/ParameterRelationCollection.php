<?php
namespace neTpyceB\TMCms\Modules\Params\Object;

use neTpyceB\TMCms\Modules\CommonObjectCollection;

class ParameterRelationCollection extends CommonObjectCollection {
    protected $db_table = 'm_params_relations';

    /**
     * @param int $item_id
     * @return $this
     */
    public function setWhereItemId($item_id)
    {
        $this->setFilterValue('item_id', $item_id);

        return $this;

    }

    /**
     * @param string $item_type
     * @return $this
     */
    public function setWhereItemType($item_type) {
        $this->setFilterValue('item_type', $item_type);

        return $this;
    }

    /**
     * @param int $param_id
     * @return $this
     */
    public function setWhereParamId($param_id) {
        $this->setFilterValue('param_id', $param_id);

        return $this;
    }
}