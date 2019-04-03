<?php
/**
 * @category    CleverSoft
 * @package     CleverMegaMenus
 * @copyright   Copyright © 2017 CleverSoft., JSC. All Rights Reserved.
 * @author 		ZooExtension.com
 * @email       magento.cleversoft@gmail.com
 */

namespace CleverSoft\MegaMenus\Block\Widget;

class Catslist extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
	protected function _toHtml(){		
		$parentId = (int)str_replace('category/','',$this->getData('parent_id'));
		$catsTree = $this->getLayout()->createBlock('CleverSoft\MegaMenus\Block\Widget\CatsTree');
		$catsTree->setData('parent_id',$parentId);
		if($this->getData('item_count')){
			$catsTree->setData('item_count',$this->getData('item_count'));
		}
		return '<ul>'.$catsTree->getHtml('', 'submenu', 0).'</ul>';	
	}
}