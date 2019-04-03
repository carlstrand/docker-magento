<?php

namespace MGS\AdvancedReports\Model\ResourceModel\Report\Collection;

class ProductCollection extends \Magento\Reports\Model\ResourceModel\Report\Collection\AbstractCollection
{
    protected $_orderStatus = null;

    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactory $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \MGS\AdvancedReports\Model\ResourceModel\Product $resource,
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
            $this->getSelect()->where('main_table.created_at >= ?', $this->_from);
        }
        if ($this->_to !== null) {
            $this->getSelect()->where('main_table.created_at <= ?', $this->_to);
        }

        return $this;
    }

    protected function _applyCustomFilter()
    {
        return $this->_applyOrderStatusFilter();
    }

    protected function _applyStoresFilterToSelect(\Magento\Framework\DB\Select $select)
    {
        $nullCheck = false;
        $storeIds = $this->_storesIds;

        if (!is_array($storeIds)) {
            $storeIds = [$storeIds];
        }

        $storeIds = array_unique($storeIds);

        if ($index = array_search(null, $storeIds)) {
            unset($storeIds[$index]);
            $nullCheck = true;
        }

        if ($nullCheck) {
            $select->where('main_table.store_id IN(?) OR main_table.store_id IS NULL', $storeIds);
        } else {
            $select->where('main_table.store_id IN(?)', $storeIds);
        }

        return $this;
    }

    protected function _applySkuFilter()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $requestData = $objectManager->get(
            'Magento\Backend\Helper\Data'
        )->prepareFilterString(
            $objectManager->get('Magento\Framework\App\Request\Http')->getParam('filter')
        );
        if (isset($requestData['sku']) && $requestData['sku'] !== null) {
            $this->getSelect()->where('sku = ?', $requestData['sku']);
        }
        return $this;
    }

    protected function _beforeLoad()
    {
        parent::_beforeLoad();

        $this->_applySkuFilter();
        $this->_applyAggregatedTable();
        $this->_applyDateRangeFilter();
        $this->_applyStoresFilter();
        $this->_applyCustomFilter();
        return $this;
    }
}
