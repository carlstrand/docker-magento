<?php
/**
 * @category    CleverSoft
 * @package     CleverBase
 * @copyright   Copyright © 2017 CleverSoft., JSC. All Rights Reserved.
 * @author 		ZooExtension.com
 * @email       magento.cleversoft@gmail.com
 */

namespace CleverSoft\Base\Model\System\Config\Source\Layout\Element;
class Displayonhover implements \Magento\Framework\Option\ArrayInterface{

    public function toOptionArray()
    {
        $types = [
            ['value' => 'remove', 'label' => __('Don\'t Display')],
            ['value' => 'hover', 'label' => __('Display On Hover')],
            ['value' => 'visible', 'label' => __('Always Display')]
        ];

        return $types;
    }

}