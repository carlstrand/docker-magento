<?php

namespace MGS\AdvancedReports\Controller\Adminhtml\Report\Sales;

use MGS\AdvancedReports\Controller\Adminhtml\Report\Sales;
use Magento\Reports\Model\Flag;

class Newandreturning extends Sales
{
    public function execute()
    {
        $this->_showLastExecutionTime(Flag::REPORT_ORDER_FLAG_CODE, 'sales');
        $this->_initAction()->_setActiveMenu(
            'MGS_AdvancedReports::advancedreports_salesbynewandreturning'
        )->_addBreadcrumb(
            __('Sales By New And Returning Customers'),
            __('Sales By New And Returning Customers')
        );
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Sales By New And Returning Customers'));
        $gridBlock = $this->_view->getLayout()->getBlock('adminhtml_sales_newandreturning.grid');
        $filterFormBlock = $this->_view->getLayout()->getBlock('grid.filter.form');
        $this->_initReportAction([$gridBlock, $filterFormBlock]);
        $this->_view->renderLayout();
    }
}
