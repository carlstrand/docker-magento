<?php

namespace MGS\AdvancedReports\Model\ResourceModel\Report\Group;

class Collection extends \MGS\AdvancedReports\Model\ResourceModel\Report\Collection\GroupCollection
{
    protected $_periodFormat;
    protected $_aggregationTable = 'sales_order';
    protected $_selectedColumns = [];

    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactory $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \MGS\AdvancedReports\Model\ResourceModel\Group $resource,
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
            $this->_periodFormat = $connection->getDateFormatSql('created_at', '%Y-%m');
        } elseif ('year' == $this->_period) {
            $this->_periodFormat = $connection->getDateExtractSql(
                'created_at',
                \Magento\Framework\DB\Adapter\AdapterInterface::INTERVAL_YEAR
            );
        } else {
            $this->_periodFormat = $connection->getDateFormatSql('created_at', '%Y-%m-%d');
        }
        if (!$this->isTotals()) {
            $this->_selectedColumns = [];
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
            ['customer_group' => $this->getTable('customer_group')],
            'main_table.customer_group_id = customer_group.customer_group_id',
            [
                'customer_group_code',
                'COUNT(main_table.entity_id) AS orders_count',
                'IFNULL(((COUNT(main_table.entity_id) / (SELECT COUNT(*) FROM ' . $this->getResource()->getMainTable() . $this->getWhereCondition() . ')) * 100), 0) AS percentage',
                'IFNULL(SUM(total_qty_ordered), 0.0000) AS total_qty_ordered',
                'IFNULL(SUM(grand_total), 0.0000) AS grand_total',
                'IFNULL(SUM(total_invoiced), 0.0000) AS total_invoiced',
                'IFNULL(SUM(total_paid), 0.0000) AS total_paid',
                'IFNULL(SUM(total_refunded), 0.0000) AS total_refunded',
                'IFNULL(SUM(tax_amount), 0.0000) AS tax_amount',
                'IFNULL(SUM(shipping_amount), 0.0000) AS shipping_amount',
                'IFNULL(SUM(discount_amount), 0.0000) AS discount_amount',
                'IFNULL(SUM(total_canceled), 0.0000) AS total_canceled'
            ]
        );
        $this->getSelect()->order('grand_total DESC');
        if (!$this->isTotals()) {
            $this->getSelect()->group('customer_group_code');
        }
        return parent::_beforeLoad();
    }

    public function getWhereCondition()
    {
        $storeIds = $this->_storesIds;
        $from = $this->_from;
        $to = $this->_to;
        $orderStatus = $this->_orderStatus;
        $where = '';
        if ($from !== null && $to !== null && $orderStatus !== null) {
            $statuses = array();
            foreach ($orderStatus as $status) {
                $statuses[] = '\'' . $status . '\'';
            }
            $where .= ' WHERE (created_at >= \'' . $from . '\') AND (created_at <= \'' . $to . '\') AND (status IN(' . implode(',', $statuses) . ')) AND (store_id IN(' . implode(',', $storeIds) . '))';
        } else if ($from !== null && $to !== null && $orderStatus == null) {
            $where .= ' WHERE (created_at >= \'' . $from . '\') AND (created_at <= \'' . $to . '\') AND (store_id IN(' . implode(',', $storeIds) . '))';
        }
        return $where;
    }
}
