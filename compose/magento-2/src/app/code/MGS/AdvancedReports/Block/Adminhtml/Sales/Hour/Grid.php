<?php

namespace MGS\AdvancedReports\Block\Adminhtml\Sales\Hour;

use Magento\Reports\Block\Adminhtml\Grid\AbstractGrid;

class Grid extends AbstractGrid
{
    protected $_columnGroupBy = 'h';
    protected $_template = 'MGS_AdvancedReports::widget/grid/hour/extended.phtml';

    protected function _construct()
    {
        parent::_construct();
        $this->setCountTotals(true);
    }

    public function getResourceCollectionName()
    {
        return 'MGS\AdvancedReports\Model\ResourceModel\Report\Hour\Collection';
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'h',
            [
                'header' => __('Hour'),
                'index' => 'h',
                'sortable' => false,
                'totals_label' => __('Total'),
                'html_decorators' => ['nobr'],
                'header_css_class' => 'col-hour-id',
                'column_css_class' => 'col-hour-id'
            ]
        );
        $this->addColumn(
            'orders_count',
            [
                'header' => __('Orders'),
                'index' => 'orders_count',
                'sortable' => false,
                'type' => 'number',
                'header_css_class' => 'col-orders',
                'column_css_class' => 'col-orders'
            ]
        );
        $this->addColumn(
            'total_qty_ordered',
            [
                'header' => __('Sales Items'),
                'index' => 'total_qty_ordered',
                'type' => 'number',
                'total' => 'sum',
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
            'grand_total',
            [
                'header' => __('Sales Total'),
                'type' => 'currency',
                'currency_code' => $currencyCode,
                'index' => 'grand_total',
                'total' => 'sum',
                'sortable' => false,
                'rate' => $rate,
                'header_css_class' => 'col-sales-total',
                'column_css_class' => 'col-sales-total'
            ]
        );
        $this->addColumn(
            'total_invoiced',
            [
                'header' => __('Invoiced'),
                'type' => 'currency',
                'currency_code' => $currencyCode,
                'index' => 'total_invoiced',
                'total' => 'sum',
                'sortable' => false,
                'visibility_filter' => ['show_actual_columns'],
                'rate' => $rate,
                'header_css_class' => 'col-invoiced',
                'column_css_class' => 'col-invoiced'
            ]
        );
        $this->addColumn(
            'total_paid',
            [
                'header' => __('Paid'),
                'type' => 'currency',
                'currency_code' => $currencyCode,
                'index' => 'total_paid',
                'total' => 'sum',
                'sortable' => false,
                'visibility_filter' => ['show_actual_columns'],
                'rate' => $rate,
                'header_css_class' => 'col-paid',
                'column_css_class' => 'col-paid'
            ]
        );
        $this->addColumn(
            'total_refunded',
            [
                'header' => __('Refunded'),
                'type' => 'currency',
                'currency_code' => $currencyCode,
                'index' => 'total_refunded',
                'total' => 'sum',
                'sortable' => false,
                'visibility_filter' => ['show_actual_columns'],
                'rate' => $rate,
                'header_css_class' => 'col-refunded',
                'column_css_class' => 'col-refunded'
            ]
        );
        $this->addColumn(
            'tax_amount',
            [
                'header' => __('Sales Tax'),
                'type' => 'currency',
                'currency_code' => $currencyCode,
                'index' => 'tax_amount',
                'total' => 'sum',
                'sortable' => false,
                'visibility_filter' => ['show_actual_columns'],
                'rate' => $rate,
                'header_css_class' => 'col-sales-tax',
                'column_css_class' => 'col-sales-tax'
            ]
        );
        $this->addColumn(
            'shipping_amount',
            [
                'header' => __('Sales Shipping'),
                'type' => 'currency',
                'currency_code' => $currencyCode,
                'index' => 'shipping_amount',
                'total' => 'sum',
                'sortable' => false,
                'visibility_filter' => ['show_actual_columns'],
                'rate' => $rate,
                'header_css_class' => 'col-sales-shipping',
                'column_css_class' => 'col-sales-shipping'
            ]
        );
        $this->addColumn(
            'discount_amount',
            [
                'header' => __('Sales Discount'),
                'type' => 'currency',
                'currency_code' => $currencyCode,
                'index' => 'discount_amount',
                'total' => 'sum',
                'sortable' => false,
                'visibility_filter' => ['show_actual_columns'],
                'rate' => $rate,
                'header_css_class' => 'col-sales-discount',
                'column_css_class' => 'col-sales-discount'
            ]
        );
        $this->addColumn(
            'total_canceled',
            [
                'header' => __('Canceled'),
                'type' => 'currency',
                'currency_code' => $currencyCode,
                'index' => 'total_canceled',
                'total' => 'sum',
                'sortable' => false,
                'visibility_filter' => ['show_actual_columns'],
                'rate' => $rate,
                'header_css_class' => 'col-canceled',
                'column_css_class' => 'col-canceled'
            ]
        );
        $this->addColumn(
            'percentage',
            [
                'header' => __('Percentage'),
                'index' => 'percentage',
                'renderer' => 'MGS\AdvancedReports\Block\Adminhtml\Sales\Grid\Column\Renderer\Percentage',
                'sortable' => false,
                'type' => 'number',
                'totals_label' => __('')
            ]
        );
        $this->addExportType('*/*/exportSalesByHourCsv', __('CSV'));
        $this->addExportType('*/*/exportSalesByHourExcel', __('Excel XML'));
        return parent::_prepareColumns();
    }
}
