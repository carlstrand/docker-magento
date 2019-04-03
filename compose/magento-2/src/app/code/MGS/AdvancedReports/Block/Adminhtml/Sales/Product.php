<?php

namespace MGS\AdvancedReports\Block\Adminhtml\Sales;

use Magento\Backend\Block\Widget\Grid\Container;

class Product extends Container
{
    protected $_template = 'report/grid/container.phtml';

    protected function _construct()
    {
        $this->_blockGroup = 'MGS_AdvancedReports';
        $this->_controller = 'adminhtml_sales_product';
        $this->_headerText = __('Sales By Product');
        parent::_construct();
        $this->buttonList->remove('add');
        $this->addButton(
            'filter_form_submit',
            ['label' => __('Show Report'), 'onclick' => 'filterFormSubmit()', 'class' => 'primary']
        );
    }

    public function getFilterUrl()
    {
        $this->getRequest()->setParam('filter', null);
        return $this->getUrl('*/*/product', ['_current' => true]);
    }
}
