<?php
/**
 * @category    CleverSoft
 * @package     CleverBase
 * @copyright   Copyright © 2017 CleverSoft., JSC. All Rights Reserved.
 * @author 		ZooExtension.com
 * @email       magento.cleversoft@gmail.com
 */

namespace CleverSoft\Base\Model\System\Config\Source\Product;

class Gallerylayout implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 'horizontal', 'label' => __('Horizontal')],
            ['value' => 'vertical', 'label' => __('Vertical')]
        ];
    }

    public function toArray()
    {
        return [
            'horizontal' => __('Horizontal'),
            'vertical' => __('Vertical')
        ];
    }
}
