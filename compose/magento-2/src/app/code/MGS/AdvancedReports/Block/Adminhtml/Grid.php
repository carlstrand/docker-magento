<?php

namespace MGS\AdvancedReports\Block\Adminhtml;

class Grid extends \Magento\Backend\Block\Widget\Grid
{
    protected $_storeSwitcherVisibility = true;
    protected $_dateFilterVisibility = true;
    protected $_filters = [];
    protected $_defaultFilters = ['report_from' => '', 'report_to' => '', 'report_period' => 'day'];
    protected $_subReportSize = 5;
    protected $_errors = [];
    protected $_template = 'MGS_AdvancedReports::grid.phtml';
    protected $_filterValues;

    protected function _prepareCollection()
    {
        $filter = $this->getParam($this->getVarNameFilter(), null);
        if (null === $filter) {
            $filter = $this->_defaultFilter;
        }
        if (is_string($filter)) {
            $data = [];
            $filter = base64_decode($filter);
            parse_str(urldecode($filter), $data);
            if (!isset($data['report_from'])) {
                $date = (new \DateTime())->setTimestamp(mktime(0, 0, 0, 1, 1, 2001));
                $data['report_from'] = $this->_localeDate->formatDateTime(
                    $date,
                    \IntlDateFormatter::SHORT,
                    \IntlDateFormatter::NONE
                );
            }
            if (!isset($data['report_to'])) {
                $date = new \DateTime();
                $data['report_to'] = $this->_localeDate->formatDateTime(
                    $date,
                    \IntlDateFormatter::SHORT,
                    \IntlDateFormatter::NONE
                );
            }
            $this->_setFilterValues($data);
        } elseif ($filter && is_array($filter)) {
            $this->_setFilterValues($filter);
        } elseif (0 !== sizeof($this->_defaultFilter)) {
            $this->_setFilterValues($this->_defaultFilter);
        }
        $collection = $this->getCollection();
        if ($collection) {
            $collection->setPeriod($this->getFilter('report_period'));

            if ($this->getFilter('report_from') && $this->getFilter('report_to')) {
                try {
                    $from = $this->_localeDate->scopeDate(null, $this->getFilter('report_from'), false);
                    $to = $this->_localeDate->scopeDate(null, $this->getFilter('report_to'), false);
                    $collection->setInterval($from, $to);
                } catch (\Exception $e) {
                    $this->_errors[] = __('Invalid date specified');
                }
            }
            $collection->setStoreIds($this->_getAllowedStoreIds());
            if ($this->getSubReportSize() !== null) {
                $collection->setPageSize($this->getSubReportSize());
            }
            $this->_eventManager->dispatch(
                'adminhtml_widget_grid_filter_collection',
                ['collection' => $this->getCollection(), 'filter_values' => $this->_filterValues]
            );
        }

        return $this;
    }

    protected function _getAllowedStoreIds()
    {
        $storeIds = [];
        if ($this->getRequest()->getParam('store')) {
            $storeIds = [$this->getParam('store')];
        } elseif ($this->getRequest()->getParam('website')) {
            $storeIds = $this->_storeManager->getWebsite($this->getRequest()->getParam('website'))->getStoreIds();
        } elseif ($this->getRequest()->getParam('group')) {
            $storeIds = $storeIds = $this->_storeManager->getGroup(
                $this->getRequest()->getParam('group')
            )->getStoreIds();
        }
        $allowedStoreIds = array_keys($this->_storeManager->getStores());
        $storeIds = array_intersect($allowedStoreIds, $storeIds);
        if (empty($storeIds)) {
            $storeIds = $allowedStoreIds;
        }
        $storeIds = array_values($storeIds);
        return $storeIds;
    }

    protected function _setFilterValues($data)
    {
        foreach ($data as $name => $value) {
            $this->setFilter($name, $data[$name]);
        }
        return $this;
    }

    public function setStoreSwitcherVisibility($visible = true)
    {
        $this->_storeSwitcherVisibility = $visible;
    }

    public function getStoreSwitcherVisibility()
    {
        return $this->_storeSwitcherVisibility;
    }

    public function getStoreSwitcherHtml()
    {
        return $this->getChildHtml('store_switcher');
    }

    public function setDateFilterVisibility($visible = true)
    {
        $this->_dateFilterVisibility = $visible;
    }

    public function getDateFilterVisibility()
    {
        return $this->_dateFilterVisibility;
    }

    public function getDateFilterHtml()
    {
        return $this->getChildHtml('date_filter');
    }

    public function getPeriods()
    {
        return $this->getCollection()->getPeriods();
    }

    public function getDateFormat()
    {
        return $this->_localeDate->getDateFormat(\IntlDateFormatter::SHORT);
    }

    public function getRefreshButtonHtml()
    {
        return $this->getChildHtml('refresh_button');
    }

    public function setFilter($name, $value)
    {
        if ($name) {
            $this->_filters[$name] = $value;
        }
    }

    public function getFilter($name)
    {
        if (isset($this->_filters[$name])) {
            return $this->_filters[$name];
        } else {
            return $this->getRequest()->getParam($name) ? htmlspecialchars($this->getRequest()->getParam($name)) : '';
        }
    }

    public function setSubReportSize($size)
    {
        $this->_subReportSize = $size;
    }

    public function getSubReportSize()
    {
        return $this->_subReportSize;
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    protected function _prepareFilterButtons()
    {
        $this->addChild(
            'refresh_button',
            'Magento\Backend\Block\Widget\Button',
            ['label' => __('Refresh'), 'onclick' => "{$this->getJsObjectName()}.doFilter();", 'class' => 'task']
        );
    }
}
