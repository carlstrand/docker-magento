<?php

namespace MGS\AdvancedReports\Controller\Adminhtml\Report;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

abstract class AbstractReport extends Action
{
    protected $_fileFactory;
    protected $_dateFilter;
    protected $timezone;

    public function __construct(
        Context $context,
        FileFactory $fileFactory,
        Date $dateFilter,
        TimezoneInterface $timezone
    )
    {
        parent::__construct($context);
        $this->_fileFactory = $fileFactory;
        $this->_dateFilter = $dateFilter;
        $this->timezone = $timezone;
    }

    protected $_adminSession = null;

    protected function _getSession()
    {
        if ($this->_adminSession === null) {
            $this->_adminSession = $this->_objectManager->get('Magento\Backend\Model\Auth\Session');
        }
        return $this->_adminSession;
    }

    public function _initAction()
    {
        $this->_view->loadLayout();
        $this->_addBreadcrumb(__('Advanced Reports'), __('Advanced Reports'));
        return $this;
    }

    public function _initReportAction($blocks)
    {
        if (!is_array($blocks)) {
            $blocks = [$blocks];
        }
        $requestData = $this->_objectManager->get(
            'Magento\Backend\Helper\Data'
        )->prepareFilterString(
            $this->getRequest()->getParam('filter')
        );
        if (isset($requestData['date_used']) && $requestData['date_used'] != 'custom') {
            $date = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->gmtDate('Y-m-d');
            $from = null;
            $to = null;
            if ($requestData['date_used'] == 'today') {
                $from = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->gmtDate('Y-m-d');
                $to = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->gmtDate('Y-m-d', strtotime($date . ' +1 day'));
            } else if ($requestData['date_used'] == 'yesterday') {
                $from = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->gmtDate('Y-m-d', strtotime($date . ' -1 day'));
                $to = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->gmtDate('Y-m-d', strtotime($date . ' -1 day'));
            } else if ($requestData['date_used'] == 'last_7_days') {
                $from = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->gmtDate('Y-m-d', strtotime($date . ' -6 day'));
                $to = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->gmtDate('Y-m-d');
            } else if ($requestData['date_used'] == 'last_week') {
                $from = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->gmtDate('Y-m-d', strtotime('last week monday'));
                $to = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->gmtDate('Y-m-d', strtotime('last week sunday'));
            } else if ($requestData['date_used'] == 'last_business_week') {
                $from = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->gmtDate('Y-m-d', strtotime('last week monday'));
                $to = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->gmtDate('Y-m-d', strtotime('last week friday'));
            } else if ($requestData['date_used'] == 'this_month') {
                $from = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->gmtDate('Y-m-d', strtotime('first day of this month'));
                $to = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->gmtDate('Y-m-d', strtotime('last day of this month'));
            } else if ($requestData['date_used'] == 'last_month') {
                $from = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->gmtDate('Y-m-d', strtotime('first day of last month'));
                $to = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->gmtDate('Y-m-d', strtotime('last day of last month'));
            } else if ($requestData['date_used'] == 'last_3_months') {
                $from = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->gmtDate('Y-m-d', strtotime('first day of -3 month'));
                $to = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->gmtDate('Y-m-d', strtotime('last day of last month'));
            } else if ($requestData['date_used'] == 'last_6_months') {
                $from = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->gmtDate('Y-m-d', strtotime('first day of -6 month'));
                $to = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->gmtDate('Y-m-d', strtotime('last day of last month'));
            } else if ($requestData['date_used'] == 'this_year') {
                $from = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->gmtDate('Y-m-d', strtotime('first day of January ' . date('Y')));
                $to = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\DateTime')->gmtDate('Y-m-d', strtotime('last day of December ' . date('Y')));
            }
            $requestData['from'] = $from;
            $requestData['to'] = $to;
        } else {
            $inputFilter = new \Zend_Filter_Input(
                ['from' => $this->_dateFilter, 'to' => $this->_dateFilter],
                [],
                $requestData
            );
            $requestData = $inputFilter->getUnescaped();
        }
        $requestData['store_ids'] = $this->getRequest()->getParam('store_ids');
        $params = new \Magento\Framework\DataObject();
        foreach ($requestData as $key => $value) {
            if (!empty($value)) {
                $params->setData($key, $value);
            }
        }
        foreach ($blocks as $block) {
            if ($block) {
                $block->setPeriodType($params->getData('period_type'));
                $block->setFilterData($params);
            }
        }
        if ($this->_request->getActionName() == 'newandreturning') {
            $resources = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\App\ResourceConnection');
            $connection = $resources->getConnection();
            $table = $resources->getTableName('mgs_advancedreports_newandreturning');
            if (isset($requestData['from']) && isset($requestData['to'])) {
                $sql = 'DELETE FROM ' . $table;
                $connection->query($sql);
                $params = $this->getRequest()->getParams();
                $storeIds = null;
                if (isset($params['website'])) {
                    $groups = $this->_objectManager->get('Magento\Store\Model\Website')->load($params['website'])->getGroups();
                    foreach ($groups as $group) {
                        foreach ($group->getStores() as $store) {
                            $storeIds[] = $store->getId();
                        }
                    }
                    $storeIds = implode(',', $storeIds);
                } else if (isset($params['group'])) {
                    $this->_objectManager->get('Magento\Store\Model\Group')->load($params['group']);
                    $stores = $this->_objectManager->get('Magento\Store\Model\Group')->load($params['group'])->getStores();
                    foreach ($stores as $store) {
                        $storeIds[] = $store->getId();
                    }
                    $storeIds = implode(',', $storeIds);
                } else if (isset($params['store_ids'])) {
                    $storeIds = $params['store_ids'];
                } else {
                    $storeIds = null;
                }
                if ($requestData['period_type'] == 'day') {
                    $period = 'DATE_FORMAT(created_at, \'%Y-%m-%d\') AS `period`, GROUP_CONCAT(customer_id SEPARATOR \',\') AS `customer_ids`';
                    $where = '';
                    if (isset($requestData['order_statuses'])) {
                        $orderStatus = explode(',', $requestData['order_statuses'][0]);
                        $statuses = array();
                        foreach ($orderStatus as $status) {
                            $statuses[] = '\'' . $status . '\'';
                        }
                        if ($storeIds == null) {
                            $where .= ' WHERE (created_at >= \'' . $from . '\') AND (created_at <= \'' . $to . '\') AND (status IN(' . implode(',', $statuses) . '))';
                        } else {
                            $where .= ' WHERE (created_at >= \'' . $from . '\') AND (created_at <= \'' . $to . '\') AND (status IN(' . implode(',', $statuses) . ')) AND (store_id IN(' . $storeIds . '))';
                        }
                    } else {
                        if ($storeIds == null) {
                            $where .= ' WHERE (created_at >= \'' . $from . '\') AND (created_at <= \'' . $to . '\')';
                        } else {
                            $where .= ' WHERE (created_at >= \'' . $from . '\') AND (created_at <= \'' . $to . '\') AND (store_id IN(' . $storeIds . '))';
                        }
                    }
                    $group = ' GROUP BY DATE_FORMAT(created_at, \'%Y-%m-%d\')';
                    $sql = 'SELECT ' . $period . ' FROM ' . $resources->getTableName('sales_order') . $where . $group;
                    $result = $connection->fetchAll($sql);
                    foreach ($result as $record) {
                        $customerIds = explode(',', $record['customer_ids']);
                        $customerIds = array_unique($customerIds);
                        $new = 0;
                        $returning = 0;
                        $total = 0;
                        foreach ($customerIds as $customerId) {
                            $sqlOrder = 'SELECT * FROM ' . $resources->getTableName('sales_order') . ' WHERE customer_id = ' . (int)$customerId;
                            $resultOrder = $connection->fetchAll($sqlOrder);
                            if (count($resultOrder) >= 2) {
                                $returning += 1;
                                $new += 0;
                            } else {
                                $new += 1;
                                $returning += 0;
                            }
                        }
                        $total = $new + $returning;
                        if ($total == 0) {
                            $percentageOfNew = '0%';
                            $percentageOfReturning = '0%';
                        } else {
                            $percentageOfNew = round(($new / $total) * 100, 1) . ' %';
                            $percentageOfReturning = round(($returning / $total) * 100, 1) . ' %';
                        }
                        $insert = 'INSERT INTO ' . $resources->getTableName('mgs_advancedreports_newandreturning') . ' (period, new_customers, returning_customers, percentage_of_new_customers, percentage_of_returning_customers) VALUES("' . $record['period'] . '",' . $new . ',' . $returning . ',"' . $percentageOfNew . '","' . $percentageOfReturning . '")';
                        $connection->query($insert);
                    }
                }
                if ($requestData['period_type'] == 'month') {
                    $period = 'DATE_FORMAT(created_at, \'%Y-%m\') AS `period`, GROUP_CONCAT(customer_id SEPARATOR \',\') AS `customer_ids`';
                    $where = '';
                    if (isset($requestData['order_statuses'])) {
                        $orderStatus = explode(',', $requestData['order_statuses'][0]);
                        $statuses = array();
                        foreach ($orderStatus as $status) {
                            $statuses[] = '\'' . $status . '\'';
                        }
                        if ($storeIds == null) {
                            $where .= ' WHERE (created_at >= \'' . $from . '\') AND (created_at <= \'' . $to . '\') AND (status IN(' . implode(',', $statuses) . '))';
                        } else {
                            $where .= ' WHERE (created_at >= \'' . $from . '\') AND (created_at <= \'' . $to . '\') AND (status IN(' . implode(',', $statuses) . ')) AND (store_id IN(' . $storeIds . '))';
                        }
                    } else {
                        if ($storeIds == null) {
                            $where .= ' WHERE (created_at >= \'' . $from . '\') AND (created_at <= \'' . $to . '\')';
                        } else {
                            $where .= ' WHERE (created_at >= \'' . $from . '\') AND (created_at <= \'' . $to . '\') AND (store_id IN(' . $storeIds . '))';
                        }
                    }
                    $group = ' GROUP BY DATE_FORMAT(created_at, \'%Y-%m\')';
                    $sql = 'SELECT ' . $period . ' FROM ' . $resources->getTableName('sales_order') . $where . $group;
                    $result = $connection->fetchAll($sql);
                    foreach ($result as $record) {
                        $customerIds = explode(',', $record['customer_ids']);
                        $customerIds = array_unique($customerIds);
                        $new = 0;
                        $returning = 0;
                        $total = 0;
                        foreach ($customerIds as $customerId) {
                            $sqlOrder = 'SELECT * FROM ' . $resources->getTableName('sales_order') . ' WHERE customer_id = ' . (int)$customerId;
                            $resultOrder = $connection->fetchAll($sqlOrder);
                            if (count($resultOrder) >= 2) {
                                $returning += 1;
                                $new += 0;
                            } else {
                                $new += 1;
                                $returning += 0;
                            }
                        }
                        $total = $new + $returning;
                        if ($total == 0) {
                            $percentageOfNew = '0%';
                            $percentageOfReturning = '0%';
                        } else {
                            $percentageOfNew = round(($new / $total) * 100, 1) . ' %';
                            $percentageOfReturning = round(($returning / $total) * 100, 1) . ' %';
                        }
                        $insert = 'INSERT INTO ' . $resources->getTableName('mgs_advancedreports_newandreturning') . ' (period, new_customers, returning_customers, percentage_of_new_customers, percentage_of_returning_customers) VALUES("' . $record['period'] . '",' . $new . ',' . $returning . ',"' . $percentageOfNew . '","' . $percentageOfReturning . '")';
                        $connection->query($insert);
                    }
                }
                if ($requestData['period_type'] == 'year') {
                    $period = 'DATE_FORMAT(created_at, \'%Y\') AS `period`, GROUP_CONCAT(customer_id SEPARATOR \',\') AS `customer_ids`';
                    $where = '';
                    if (isset($requestData['order_statuses'])) {
                        $orderStatus = explode(',', $requestData['order_statuses'][0]);
                        $statuses = array();
                        foreach ($orderStatus as $status) {
                            $statuses[] = '\'' . $status . '\'';
                        }
                        if ($storeIds == null) {
                            $where .= ' WHERE (created_at >= \'' . $from . '\') AND (created_at <= \'' . $to . '\') AND (status IN(' . implode(',', $statuses) . '))';
                        } else {
                            $where .= ' WHERE (created_at >= \'' . $from . '\') AND (created_at <= \'' . $to . '\') AND (status IN(' . implode(',', $statuses) . ')) AND (store_id IN(' . $storeIds . '))';
                        }
                    } else {
                        if ($storeIds == null) {
                            $where .= ' WHERE (created_at >= \'' . $from . '\') AND (created_at <= \'' . $to . '\')';
                        } else {
                            $where .= ' WHERE (created_at >= \'' . $from . '\') AND (created_at <= \'' . $to . '\') AND (store_id IN(' . $storeIds . '))';
                        }
                    }
                    $group = ' GROUP BY DATE_FORMAT(created_at, \'%Y\')';
                    $sql = 'SELECT ' . $period . ' FROM ' . $resources->getTableName('sales_order') . $where . $group;
                    $result = $connection->fetchAll($sql);
                    foreach ($result as $record) {
                        $customerIds = explode(',', $record['customer_ids']);
                        $customerIds = array_unique($customerIds);
                        $new = 0;
                        $returning = 0;
                        $total = 0;
                        foreach ($customerIds as $customerId) {
                            $sqlOrder = 'SELECT * FROM ' . $resources->getTableName('sales_order') . ' WHERE customer_id = ' . (int)$customerId;
                            $resultOrder = $connection->fetchAll($sqlOrder);
                            if (count($resultOrder) >= 2) {
                                $returning += 1;
                                $new += 0;
                            } else {
                                $new += 1;
                                $returning += 0;
                            }
                        }
                        $total = $new + $returning;
                        if ($total == 0) {
                            $percentageOfNew = '0%';
                            $percentageOfReturning = '0%';
                        } else {
                            $percentageOfNew = round(($new / $total) * 100, 1) . ' %';
                            $percentageOfReturning = round(($returning / $total) * 100, 1) . ' %';
                        }
                        $insert = 'INSERT INTO ' . $resources->getTableName('mgs_advancedreports_newandreturning') . ' (period, new_customers, returning_customers, percentage_of_new_customers, percentage_of_returning_customers) VALUES("' . $record['period'] . '",' . $new . ',' . $returning . ',"' . $percentageOfNew . '","' . $percentageOfReturning . '")';
                        $connection->query($insert);
                    }
                }
            } else {
                $sql = 'DELETE FROM ' . $table;
                $connection->query($sql);
            }
        }
        return $this;
    }

    protected function _showLastExecutionTime($flagCode, $refreshCode)
    {
        $flag = $this->_objectManager->create('Magento\Reports\Model\Flag')->setReportFlagCode($flagCode)->loadSelf();
        $updatedAt = 'undefined';
        if ($flag->hasData()) {
            $updatedAt = $this->timezone->formatDate(
                $flag->getLastUpdate(),
                \IntlDateFormatter::MEDIUM,
                true
            );
        }
        $refreshStatsLink = $this->getUrl('reports/report_statistics');
        $directRefreshLink = $this->getUrl('reports/report_statistics/refreshRecent', ['code' => $refreshCode]);
        $this->messageManager->addNotice(
            __(
                'Last updated: %1. To refresh last day\'s <a href="%2">statistics</a>, ' .
                'click <a href="%3">here</a>.',
                $updatedAt,
                $refreshStatsLink,
                $directRefreshLink
            )
        );
        return $this;
    }
}
