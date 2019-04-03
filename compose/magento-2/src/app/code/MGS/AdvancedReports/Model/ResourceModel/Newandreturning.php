<?php

namespace MGS\AdvancedReports\Model\ResourceModel;

class Newandreturning extends \Magento\Sales\Model\ResourceModel\EntityAbstract
{
    protected function _construct()
    {
        $this->_init('mgs_advancedreports_newandreturning', 'id');
    }

    public function init($table, $field = 'id')
    {
        $this->_init($table, $field);
        return $this;
    }
}
