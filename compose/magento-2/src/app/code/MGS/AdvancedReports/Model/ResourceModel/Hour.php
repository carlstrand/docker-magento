<?php

namespace MGS\AdvancedReports\Model\ResourceModel;

class Hour extends \Magento\Sales\Model\ResourceModel\EntityAbstract
{
    protected function _construct()
    {
        $this->_init('sales_order', 'entity_id');
    }

    public function init($table, $field = 'entity_id')
    {
        $this->_init($table, $field);
        return $this;
    }
}
