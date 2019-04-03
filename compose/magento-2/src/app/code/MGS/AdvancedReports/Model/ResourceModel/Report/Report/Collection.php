<?php

namespace MGS\AdvancedReports\Model\ResourceModel\Report\Report;

class Collection extends \MGS\AdvancedReports\Model\ResourceModel\Report\Collection\ReportCollection
{
    protected $_periodFormat;
    protected $_aggregationTable = 'sales_order_item';
    protected $_selectedColumns = [];

    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactory $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \MGS\AdvancedReports\Model\ResourceModel\Report $resource,
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
            $this->_periodFormat = $connection->getDateFormatSql('sales_order.created_at', '%Y-%m');
        } elseif ('year' == $this->_period) {
            $this->_periodFormat = $connection->getDateExtractSql(
                'sales_order.created_at',
                \Magento\Framework\DB\Adapter\AdapterInterface::INTERVAL_YEAR
            );
        } else {
            $this->_periodFormat = $connection->getDateFormatSql('sales_order.created_at', '%Y-%m-%d');
        }
        if (!$this->isTotals()) {
            $this->_selectedColumns = [
                'increment_id' => 'sales_order.increment_id',
                'name' => 'name',
                'sku' => 'sku',
                'price' => 'price',
                'qty_ordered' => 'qty_ordered',
                'qty_shipped' => 'qty_shipped',
                'qty_invoiced' => 'qty_invoiced'
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
                'status',
                'increment_id',
                'IFNULL(SUM(row_total) + SUM(main_table.tax_amount) - SUM(main_table.discount_amount), 0.0000) AS row_total',
                'IFNULL(SUM(main_table.tax_amount), 0.0000) AS tax_amount',
                'IFNULL(SUM(main_table.discount_amount), 0.0000) AS discount_amount',
            ]
        );
        if (!$this->isTotals()) {
            $this->getSelect()->group('increment_id')
                ->group('sku');
        }
        $this->getSelect()->order('increment_id DESC');
        return parent::_beforeLoad();
    }
}
