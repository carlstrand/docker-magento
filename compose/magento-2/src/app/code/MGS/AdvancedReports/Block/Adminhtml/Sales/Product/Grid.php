<?php

namespace MGS\AdvancedReports\Block\Adminhtml\Sales\Product;

use Magento\Reports\Block\Adminhtml\Grid\AbstractGrid;

class Grid extends AbstractGrid
{
    protected $_columnGroupBy = 'period';
    protected $_template = 'MGS_AdvancedReports::widget/grid/product/extended.phtml';

    protected function _construct()
    {
        parent::_construct();
        $this->setCountTotals(true);
    }

    public function getResourceCollectionName()
    {
        return 'MGS\AdvancedReports\Model\ResourceModel\Report\Product\Collection';
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
                'period_type' => $this->getPeriodType(),
                'renderer' => 'Magento\Reports\Block\Adminhtml\Sales\Grid\Column\Renderer\Date',
                'totals_label' => __('Total'),
                'html_decorators' => ['nobr'],
                'header_css_class' => 'col-period',
                'column_css_class' => 'col-period'
            ]
        );
        $this->addColumn(
            'qty_ordered',
            [
                'header' => __('Qty Ordered'),
                'index' => 'qty_ordered',
                'type' => 'number',
                'total' => 'sum',
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
                'total' => 'sum',
                'sortable' => false,
                'visibility_filter' => ['show_actual_columns'],
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
                'total' => 'sum',
                'sortable' => false,
                'visibility_filter' => ['show_actual_columns'],
                'header_css_class' => 'col-sales-items',
                'column_css_class' => 'col-sales-items'
            ]
        );
        $this->addColumn(
            'qty_refunded',
            [
                'header' => __('Qty Refunded'),
                'index' => 'qty_refunded',
                'type' => 'number',
                'total' => 'sum',
                'sortable' => false,
                'visibility_filter' => ['show_actual_columns'],
                'header_css_class' => 'col-sales-items',
                'column_css_class' => 'col-sales-items'
            ]
        );
        $this->addColumn(
            'qty_canceled',
            [
                'header' => __('Qty Canceled'),
                'index' => 'qty_canceled',
                'type' => 'number',
                'total' => 'sum',
                'sortable' => false,
                'visibility_filter' => ['show_actual_columns'],
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
            'original_price',
            [
                'header' => __('Original Price'),
                'type' => 'currency',
                'currency_code' => $currencyCode,
                'index' => 'original_price',
                'sortable' => false,
                'visibility_filter' => ['show_actual_columns'],
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
                'total' => 'sum',
                'sortable' => false,
                'rate' => $rate,
                'header_css_class' => 'col-sales-total',
                'column_css_class' => 'col-sales-total'
            ]
        );
        $this->addExportType('*/*/exportSalesByProductCsv', __('CSV'));
        $this->addExportType('*/*/exportSalesByProductExcel', __('Excel XML'));
        return parent::_prepareColumns();
    }
}
