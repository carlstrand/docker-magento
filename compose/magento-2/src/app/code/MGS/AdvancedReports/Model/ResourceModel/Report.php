<?php

namespace MGS\AdvancedReports\Model\ResourceModel;

class Report extends \Magento\Sales\Model\ResourceModel\EntityAbstract
{
    protected function _construct()
    {
        $this->_init('sales_order_item', 'item_id');
    }

    public function init($table, $field = 'item_id')
    {
        $this->_init($table, $field);
        return $this;
    }
}
