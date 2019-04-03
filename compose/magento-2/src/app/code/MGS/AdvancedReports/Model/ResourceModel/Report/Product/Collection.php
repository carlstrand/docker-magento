<?php

namespace MGS\AdvancedReports\Model\ResourceModel\Report\Product;

class Collection extends \MGS\AdvancedReports\Model\ResourceModel\Report\Collection\ProductCollection
{
    protected $_periodFormat;
    protected $_aggregationTable = 'sales_order_item';
    protected $_selectedColumns = [];

    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactory $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \MGS\AdvancedReports\Model\ResourceModel\Product $resource,
        \Magento\Framework\DB\Adapter\AdapterInterface $connection = null
    )
    {
        $resource->init($this->_aggregationTable);
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $resource, $connection);
    }

    protected function _getSelectedColumns()
    {
        $connection = $this->getConnection();
        if ('month' == $this->_period) {
            $this->_periodFormat = $connection->getDateFormatSql('main_table.created_at', '%Y-%m');
        } elseif ('year' == $this->_period) {
            $this->_periodFormat = $connection->getDateExtractSql(
                'main_table.created_at',
                \Magento\Framework\DB\Adapter\AdapterInterface::INTERVAL_YEAR
            );
        } else {
            $this->_periodFormat = $connection->getDateFormatSql('main_table.created_at', '%Y-%m-%d');
        }
        if (!$this->isTotals()) {
            $this->_selectedColumns = [
                'period' => $this->_periodFormat,
                'price' => 'price',
                'original_price' => 'original_price'
            ];
        }
        if ($this->isTotals()) {
            $this->_selectedColumns = $this->getAggregatedColumns();
        }
        return $this->_selectedColumns;
    }

    protected function _beforeLoad()
    {
        $this->getSelect()->from(['main_table' => $this->getResource()->getMainTable()], $this->_getSelectedColumns());
        $this->getSelect()->join(
            ['sales_order' => $this->getTable('sales_order')],
            'main_table.order_id = sales_order.entity_id',
            [
                'IFNULL(SUM(qty_ordered), 0.0000) AS qty_ordered',
                'IFNULL(SUM(qty_shipped), 0.0000) AS qty_shipped',
                'IFNULL(SUM(qty_invoiced), 0.0000) AS qty_invoiced',
                'IFNULL(SUM(qty_refunded), 0.0000) AS qty_refunded',
                'IFNULL(SUM(qty_canceled), 0.0000) AS qty_canceled',
                'IFNULL(SUM(row_total) + SUM(main_table.tax_amount) - SUM(main_table.discount_amount), 0.0000) AS row_total',
                'IFNULL(SUM(main_table.tax_amount), 0.0000) AS tax_amount',
                'IFNULL(SUM(main_table.discount_amount), 0.0000) AS discount_amount',
                'status'
            ]
        );
        if (!$this->isTotals()) {
            $this->getSelect()->group($this->_periodFormat);
        }
        return parent::_beforeLoad();
    }
}
