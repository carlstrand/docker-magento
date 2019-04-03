<?php
/**
 * @category    CleverSoft
 * @package     CleverBase
 * @copyright   Copyright © 2017 CleverSoft., JSC. All Rights Reserved.
 * @author 		ZooExtension.com
 * @email       magento.cleversoft@gmail.com
 */

namespace CleverSoft\Base\Model\System\Config\Source\Product;

class Pagelayout implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 'default', 'label' => __('Default')],
            ['value' => 'sticky_2', 'label' => __('Sticky 2')]
        ];
    }

    public function toArray()
    {
        return [
            'default' => __('Default'),
            'sticky_2' => __('Sticky 2')
        ];
    }
}
