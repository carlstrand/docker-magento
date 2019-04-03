<?php

namespace MGS\AdvancedReports\Model\ResourceModel\Report\Newandreturning;

class Collection extends \MGS\AdvancedReports\Model\ResourceModel\Report\Collection\NewandreturningCollection
{
    protected $_periodFormat;
    protected $_aggregationTable = 'mgs_advancedreports_newandreturning';
    protected $_selectedColumns = [];

    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactory $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \MGS\AdvancedReports\Model\ResourceModel\Newandreturning $resource,
        \Magento\Framework\DB\Adapter\AdapterInterface $connection = null
    )
    {
        $resource->init($this->_aggregationTable);
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $resource, $connection);
    }

    protected function _getSelectedColumns()
    {
        if (!$this->isTotals()) {
            $this->_selectedColumns = [
                'period' => 'period',
                'new_customers' => 'IFNULL(new_customers, 0)',
                'returning_customers' => 'IFNULL(returning_customers, 0)',
                'percentage_of_new_customers' => 'percentage_of_new_customers',
                'percentage_of_returning_customers' => 'percentage_of_returning_customers'
            ];
        }
        if ($this->isTotals()) {
            $this->_selectedColumns = $this->getAggregatedColumns();
        }
        return $this->_selectedColumns;
    }

    protected function _beforeLoad()
    {
        $this->getSelect()->from($this->getResource()->getMainTable(), $this->_getSelectedColumns());
        if (!$this->isTotals()) {
            $this->getSelect()->group('period');
        }
        return parent::_beforeLoad();
    }
}
