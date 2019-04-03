<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Used in creating options for Yes|No config value selection
 *
 */
namespace MGS\Mpanel\Model\Config\Source;

class Portfoliocolumn implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
			['value' => '2', 'label' => __('2 Column')], 
			['value' => '3', 'label' => __('3 Column')], 
			['value' => '4', 'label' => __('4 Column')],
			['value' => '5', 'label' => __('5 Column')]
		];
    }
}
