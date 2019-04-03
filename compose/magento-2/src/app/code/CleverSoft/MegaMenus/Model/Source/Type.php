<?php
/**
 * @category    CleverSoft
 * @package     CleverMegaMenus
 * @copyright   Copyright © 2017 CleverSoft., JSC. All Rights Reserved.
 * @author 		ZooExtension.com
 * @email       magento.cleversoft@gmail.com
 */

namespace CleverSoft\MegaMenus\Model\Source;
class Type implements \Magento\Framework\Data\OptionSourceInterface
{
	protected $megamenu;
	public function __construct(\CleverSoft\MegaMenus\Model\Megamenu $megamenu)
    {
        $this->megamenu = $megamenu;
    }
	public function toOptionArray()
	{
		$options[] = ['label' => '', 'value' => ''];
		$availableOptions = $this->megamenu->getAvailableTypes();
		foreach ($availableOptions as $key => $value) {
			$options[] = [
				'label' => $value,
				'value' => $key,
			];
		}
		return $options;
	}
}