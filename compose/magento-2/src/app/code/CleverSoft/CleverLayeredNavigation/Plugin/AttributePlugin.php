<?php
/**
 * @category    CleverSoft
 * @package     CleverLayeredNavigation
 * @copyright   Copyright © 2017 CleverSoft., JSC. All Rights Reserved.
 * @author 		ZooExtension.com
 * @email       magento.cleversoft@gmail.com
 */


namespace CleverSoft\CleverLayeredNavigation\Plugin;


use CleverSoft\CleverLayeredNavigation\Model\FilterSetting;
use CleverSoft\CleverLayeredNavigation\Model\FilterSettingFactory;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;

class AttributePlugin
{
    /** @var  FilterSetting */
    protected $_setting;

    public function __construct(FilterSettingFactory $settingFactory)
    {
        $this->_setting = $settingFactory->create();
    }

    public function aroundSave(Attribute $subject, \Closure $proceed)
    {
        if (!$subject->hasData('filter_code')) {
            return $proceed();
        }

        $filterCode = 'attr_' . $subject->getAttributeCode();
        $this->_setting->load($filterCode, 'filter_code');
        $this->_setting->addData($subject->getData());
        $currentFilterCode = $this->_setting->getFilterCode();
        if(empty($currentFilterCode)) {
            $this->_setting->setFilterCode($filterCode);
        }

        $connection = $this->_setting->getResource()->getConnection();
        try {
            $connection->beginTransaction();
            $this->_setting->save();
            $result = $proceed();
            $connection->commit();
        } catch(\Exception $e) {
            $connection->rollBack();
            throw $e;
        }

        return $result;
    }
}
