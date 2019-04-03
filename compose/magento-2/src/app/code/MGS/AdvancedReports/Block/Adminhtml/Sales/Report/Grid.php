<?php

namespace MGS\AdvancedReports\Block\Adminhtml\Sales\Report;

use Magento\Reports\Block\Adminhtml\Grid\AbstractGrid;

class Grid extends AbstractGrid
{
    protected $_columnGroupBy = 'increment_id';
    protected $_template = 'MGS_AdvancedReports::widget/grid/report/extended.phtml';

    protected function _construct()
    {
        parent::_construct();
        $this->setCountTotals(true);
    }

    public function getResourceCollectionName()
    {
        return 'MGS\AdvancedReports\Model\ResourceModel\Report\Report\Collection';
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'increment_id',
            [
                'header' => __('Order #'),
                'index' => 'increment_id',
                'width' => 100,
                'type' => 'text',
                'renderer' => 'MGS\AdvancedReports\Block\Adminhtml\Sales\Grid\Column\Renderer\Incrementid',
                'sortable' => false,
                'totals_label' => __('Total'),
                'html_decorators' => ['nobr'],
                'header_css_class' => 'col-increment-id',
                'column_css_class' => 'col-increment-id'
            ]
        );
        $this->addColumn(
            'name',
            [
                'header' => __('Product Name'),
                'index' => 'name',
                'sortable' => false
            ]
        );
        $this->addColumn(
            'sku',
            [
                'header' => __('SKU'),
                'index' => 'sku',
                'sortable' => false
            ]
        );
        $this->addColumn(
            'qty_ordered',
            [
                'header' => __('Qty Ordered'),
                'index' => 'qty_ordered',
                'type' => 'number',
                'sortable' => false,
                'header_css_class' => 'col-sales-items',
                'column_css_class' => 'col-sales-items'
            ]
        );
        $this->addColumn(
            'qty_shipped',
            [
                'header' => __('Qty Shipped'),
                'index' => 'qty_shipped',
                'type' => 'number',
                'sortable' => false,
                'header_css_class' => 'col-sales-items',
                'column_css_class' => 'col-sales-items'
            ]
        );
        $this->addColumn(
            'qty_invoiced',
            [
                'header' => __('Qty Invoiced'),
                'index' => 'qty_invoiced',
                'type' => 'number',
                'sortable' => false,
                'header_css_class' => 'col-sales-items',
                'column_css_class' => 'col-sales-items'
            ]
        );
        if ($this->getFilterData()->getStoreIds()) {
            $this->setStoreIds(explode(',', $this->getFilterData()->getStoreIds()));
        }
        $currencyCode = $this->getCurrentCurrencyCode();
        $rate = $this->getRate($currencyCode);
        $this->addColumn(
            'price',
            [
                'header' => __('Price'),
                'type' => 'currency',
                'currency_code' => $currencyCode,
                'index' => 'price',
                'sortable' => false,
                'rate' => $rate,
                'header_css_class' => 'col-sales-total',
                'column_css_class' => 'col-sales-total'
            ]
        );
        $this->addColumn(
            'tax_amount',
            [
                'header' => __('Tax Amount'),
                'type' => 'currency',
                'currency_code' => $currencyCode,
                'index' => 'tax_amount',
                'sortable' => false,
                'rate' => $rate,
                'header_css_class' => 'col-sales-total',
                'column_css_class' => 'col-sales-total'
            ]
        );
        $this->addColumn(
            'discount_amount',
            [
                'header' => __('Discount Amount'),
                'type' => 'currency',
                'currency_code' => $currencyCode,
                'index' => 'discount_amount',
                'sortable' => false,
                'rate' => $rate,
                'header_css_class' => 'col-sales-total',
                'column_css_class' => 'col-sales-total'
            ]
        );
        $this->addColumn(
            'row_total',
            [
                'header' => __('Row Total'),
                'type' => 'currency',
                'currency_code' => $currencyCode,
                'index' => 'row_total',
                'sortable' => false,
                'rate' => $rate,
                'header_css_class' => 'col-sales-total',
                'column_css_class' => 'col-sales-total'
            ]
        );
        $this->addExportType('*/*/exportSalesReportCsv', __('CSV'));
        $this->addExportType('*/*/exportSalesReportExcel', __('Excel XML'));
        return parent::_prepareColumns();
    }
}
