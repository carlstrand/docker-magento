<?php
/**
 * @category    CleverSoft
 * @package     CleverBase
 * @copyright   Copyright © 2017 CleverSoft., JSC. All Rights Reserved.
 * @author 		ZooExtension.com
 * @email       magento.cleversoft@gmail.com
 */

namespace CleverSoft\Base\Plugin\Product\View;

use Magento\Catalog\Helper\Image;

class Gallery
{

    const DEFAULT_ZOOM_SIZE = 1.6;

    public function __construct(Image $imagehelper, \CleverSoft\Base\Helper\Data $core_helper)
    {
        $this->_imagehelper = $imagehelper;
        $this->_core_helper = $core_helper;
    }

    public function afterGetTemplate(\Magento\Catalog\Block\Product\View\Gallery $subject, $result)
    {
        if ($subject->getNameInLayout() == 'product.info.media.image') {
            if ($this->_core_helper->getCfg('product_page/page_layout') == 'sticky_2') {
                return 'CleverSoft_Base::product/sticky/view/gallery.phtml';
            } else if ($this->_core_helper->getCfg('product_page/page_layout') == 'default') {
                return $result;
            }
        }
        return $result;
    }

    public function afterGetGalleryImages(\Magento\Catalog\Block\Product\View\Gallery $subject, $result){
        $product = $subject->getProduct();
        $images = $result;

        $keepAspectRatio = true;
        $keepFrame = false;
        $thump_image_width = $this->_core_helper->getCfg('product_page/thumb_image_width');
        $main_image_width = $this->_core_helper->getCfg('product_page/main_image_width');
        $main_image_height = null;
        $zoom_image_width = $main_image_width * self::DEFAULT_ZOOM_SIZE;
        $zoom_image_height = null;

        $keep_ratio = $this->_core_helper->getCfg('product_page/aspect_ratio');
        if (!$keep_ratio){
            $keepFrame = true;
            $main_image_height = $this->_core_helper->getCfg('product_page/main_image_height');
            $zoom_image_height = $main_image_height * self::DEFAULT_ZOOM_SIZE;
        }

        if ($images instanceof \Magento\Framework\Data\Collection) {
            foreach ($images as $image) {
                $image->setData(
                    'small_image_url',
                    $this->_imagehelper->init($product, 'product_page_image_small')
                        ->setImageFile($image->getFile())
                        ->keepAspectRatio(true)
                        ->keepFrame(false)
                        ->resize($thump_image_width)
                        ->getUrl()
                );
                $image->setData(
                    'medium_image_url',
                    $this->_imagehelper->init($product, 'product_page_image_medium_no_frame')
                        ->setImageFile($image->getFile())
                        ->keepAspectRatio($keepAspectRatio)
                        ->keepFrame($keepFrame)
                        ->resize($main_image_width, $main_image_height)
                        ->getUrl()
                );
                $image->setData(
                    'large_image_url',
                    $this->_imagehelper->init($product, 'product_page_image_large_no_frame')
                        ->setImageFile($image->getFile())
                        ->keepAspectRatio($keepAspectRatio)
                        ->keepFrame($keepFrame)
                        ->resize($zoom_image_width, $zoom_image_height)
                        ->getUrl()
                );
            }
        }

        return $images;
    }

}