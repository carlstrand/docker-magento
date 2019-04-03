<?php

namespace MGS\AdvancedReports\Model\ResourceModel\Report\Collection;

class CountryCollection extends \Magento\Reports\Model\ResourceModel\Report\Collection\AbstractCollection
{
    protected $_orderStatus = null;

    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactory $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \MGS\AdvancedReports\Model\ResourceModel\Country $resource,
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
        if ($this->_orderStatus === null) {
            return $this;
        }
        $orderStatus = $this->_orderStatus;
        if (!is_array($orderStatus)) {
            $orderStatus = [$orderStatus];
        }
        $this->getSelect()->where('status IN(?)', $orderStatus);
        return $this;
    }

    protected function _applyDateRangeFilter()
    {
        if ($this->_from !== null) {
            $this->getSelect()->where('created_at >= ?', $this->_from);
        }
        if ($this->_to !== null) {
            $this->getSelect()->where('created_at <= ?', $this->_to);
        }

        return $this;
    }

    protected function _applyCustomFilter()
    {
        return $this->_applyOrderStatusFilter();
    }
}
