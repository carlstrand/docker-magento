<?php

namespace MGS\AdvancedReports\Block\Adminhtml\Sales\Newandreturning;

use Magento\Reports\Block\Adminhtml\Grid\AbstractGrid;

class Grid extends AbstractGrid
{
    protected $_columnGroupBy = 'period';
    protected $_template = 'MGS_AdvancedReports::widget/grid/newandreturning/extended.phtml';

    protected function _construct()
    {
        parent::_construct();
        $this->setCountTotals(true);
    }

    public function getResourceCollectionName()
    {
        return 'MGS\AdvancedReports\Model\ResourceModel\Report\Newandreturning\Collection';
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'period',
            [
                'header' => __('Interval'),
                'index' => 'period',
                'width' => 100,
                'sortable' => false,
                'type' => 'text',
                'totals_label' => __('Total'),
                'html_decorators' => ['nobr'],
                'header_css_class' => 'col-period',
                'column_css_class' => 'col-period'
            ]
        );
        $this->addColumn(
            'new_customers',
            [
                'header' => __('New Customers'),
                'index' => 'new_customers',
                'type' => 'number',
                'total' => 'sum',
                'sortable' => false
            ]
        );
        $this->addColumn(
            'returning_customers',
            [
                'header' => __('Returning Customers'),
                'index' => 'returning_customers',
                'type' => 'number',
                'total' => 'sum',
                'sortable' => false
            ]
        );
        $this->addColumn(
            'percentage_of_new_customers',
            [
                'header' => __('Percentage Of New Customers'),
                'index' => 'percentage_of_new_customers',
                'type' => 'text',
                'sortable' => false
            ]
        );
        $this->addColumn(
            'percentage_of_returning_customers',
            [
                'header' => __('Percentage Of Returning Customers'),
                'index' => 'percentage_of_returning_customers',
                'type' => 'text',
                'sortable' => false
            ]
        );
        $this->addExportType('*/*/exportSalesByNewandreturningCsv', __('CSV'));
        $this->addExportType('*/*/exportSalesByNewandreturningExcel', __('Excel XML'));
        return parent::_prepareColumns();
    }
}
