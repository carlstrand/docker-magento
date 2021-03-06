<?php
/**
 * @category    CleverSoft
 * @package     CleverBrands
 * @copyright   Copyright © 2017 CleverSoft., JSC. All Rights Reserved.
 * @author 		ZooExtension.com
 * @email       magento.cleversoft@gmail.com
 */

namespace CleverSoft\CleverBrands\Model\Config\Source;

class Layoutwg implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 'carousel', 'label' => __('Carousel')],
            ['value' => 'grid', 'label' => __('Grid')],
            ['value' => 'vertical', 'label' => __('Vertical Carousel')],
        ];
    }
}