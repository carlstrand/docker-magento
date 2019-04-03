<?php
/**
 * @category    CleverSoft
 * @package     CleverLayeredNavigation
 * @copyright   Copyright © 2017 CleverSoft., JSC. All Rights Reserved.
 * @author 		ZooExtension.com
 * @email       magento.cleversoft@gmail.com
 */

namespace CleverSoft\CleverLayeredNavigation\Helper;


use Magento\Catalog\Model\Layer;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Helper\AbstractHelper;
use CleverSoft\CleverLayeredNavigation;

class Data extends AbstractHelper
{
    /** @var FilterSetting */
    protected $settingHelper;

    /** @var  Layer */
    protected $layer;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    public function __construct(
        Context $context,
        FilterSetting $settingHelper,
        Layer\Resolver $layerResolver,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->settingHelper = $settingHelper;
        $this->layer = $layerResolver->get();
        $this->storeManager = $storeManager;
    }

    public function getSelectedFiltersSettings()
    {
        $appliedItems = $this->layer->getState()->getFilters();
        $result = [];
        foreach ($appliedItems as $item) {
            $filter = $item->getFilter();
            $setting = $this->settingHelper->getSettingByLayerFilter($filter);
            $result[] = [
                'filter' => $filter,
                'setting' => $setting,
            ];
        }
        return $result;
    }

    public function isAjaxEnabled()
    {
        return $this->scopeConfig->isSetFlag('clevershopby/general/ajax_enabled', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getTooltipUrl()
    {
        $baseUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $tooltipImage = $this->scopeConfig->getValue('clevershopby/tooltips/image', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if(empty($tooltipImage)) {
            return '';
        }
        return $baseUrl . $tooltipImage;
    }
}
