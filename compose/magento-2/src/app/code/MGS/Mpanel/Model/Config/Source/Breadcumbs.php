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

class Breadcumbs implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
			['value' => '1', 'label' => __('Only Breadcumbs')],
			['value' => '2', 'label' => __('Title left and Breadcumbs rights')],
			['value' => '3', 'label' => __('Breadcumbs Center')]
		];
    }
}
