<?php
/**
 * @category    CleverSoft
 * @package     CleverMegaMenus
 * @copyright   Copyright © 2017 CleverSoft., JSC. All Rights Reserved.
 * @author 		ZooExtension.com
 * @email       magento.cleversoft@gmail.com
 */

namespace CleverSoft\MegaMenus\Model;

class Menuoptions implements \Magento\Framework\Option\ArrayInterface {

	protected $_collection;

	public function __construct(
		\CleverSoft\MegaMenus\Model\ResourceModel\Megamenu\Collection $collection
	){
		$this->_collection = $collection;
	}


	public function toOptionArray(){
		
        $collection = $this->_collection;
		$menu = [];
		foreach($collection as $item) {
            $menu[] = [
                'label' => $item->getTitle(),
                'value' => $item->getIdentifier() ,
            ];
        }	
		return $menu;
    }
}
