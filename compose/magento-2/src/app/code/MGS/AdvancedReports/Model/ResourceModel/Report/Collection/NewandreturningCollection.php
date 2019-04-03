<?php

namespace MGS\AdvancedReports\Model\ResourceModel\Report\Collection;

class NewandreturningCollection extends \Magento\Reports\Model\ResourceModel\Report\Collection\AbstractCollection
{
    protected $_orderStatus = null;

    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactory $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \MGS\AdvancedReports\Model\ResourceModel\Newandreturning $resource,
        \Magento\Framework\DB\Adapter\AdapterInterface $connection = null
    )
    {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->setModel('Magento\Reports\Model\Item');
    }

    public function addOrderStatusFilter($orderStatus)
    {
        $this->_orderStatus = $orderStatus;
        return $this;
    }

    protected function _applyOrderStatusFilter()
    {
        return $this;
    }

    protected function _applyAggregatedTable()
    {
        return $this;
    }

    protected function _applyDateRangeFilter()
    {
        return $this;
    }

    protected function _applyCustomFilter()
    {
        return $this->_applyOrderStatusFilter();
    }

    protected function _applyStoresFilterToSelect(\Magento\Framework\DB\Select $select)
    {
        return $this;
    }

    protected function _beforeLoad()
    {
        parent::_beforeLoad();

//        $this->_applyAggregatedTable();
//        $this->_applyDateRangeFilter();
//        $this->_applyStoresFilter();
//        $this->_applyCustomFilter();
        return $this;
    }
}
