<?php

namespace MGS\AdvancedReports\Block\Adminhtml\Sales;

use Magento\Backend\Block\Widget\Grid\Container;

class Group extends Container
{
    protected $_template = 'report/grid/container.phtml';

    protected function _construct()
    {
        $this->_blockGroup = 'MGS_AdvancedReports';
        $this->_controller = 'adminhtml_sales_group';
        $this->_headerText = __('Sales By Customer Group');
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
        return $this->getUrl('*/*/group', ['_current' => true]);
    }
}
