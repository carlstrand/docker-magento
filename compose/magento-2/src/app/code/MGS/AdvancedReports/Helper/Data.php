<?php

namespace MGS\AdvancedReports\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Directory\Model\Country;

class Data extends AbstractHelper
{
    protected $storeManager;
    protected $country;

    public function __construct(
        Context $context,
        Country $country,
        StoreManagerInterface $storeManager
    )
    {
        $this->country = $country;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    public function getConfig($key, $store = null)
    {
        if ($store == null || $store == '') {
            $store = $this->storeManager->getStore()->getId();
        }
        $store = $this->storeManager->getStore($store);
        $config = $this->scopeConfig->getValue(
            'advancedreports/' . $key,
            ScopeInterface::SCOPE_STORE,
            $store);
        return $config;
    }

    public function getCountryName($code)
    {
        return $this->country->loadByCode($code)->getName();
    }
}
