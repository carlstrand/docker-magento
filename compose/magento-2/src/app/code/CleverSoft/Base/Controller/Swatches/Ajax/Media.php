<?php
/**
 *
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace CleverSoft\Base\Controller\Swatches\Ajax;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Catalog\Model\Product;
use CleverSoft\Base\Model\Swatches\Ajax\Media as ModelMedia;

/**
 * Class Media
 *
 * @package Magento\Swatches\Controller\Ajax
 */
class Media extends \Magento\Swatches\Controller\Ajax\Media
{
    /**
     * @var \Magento\Swatches\Helper\Data
     */
    protected $swatchHelper;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $productModelFactory;

    /**
     * @param Context $context
     * @param \Magento\Swatches\Helper\Data $swatchHelper
     * @param \Magento\Catalog\Model\ProductFactory $productModelFactory
     */
    public function __construct(
        Context $context,
        \Magento\Swatches\Helper\Data $swatchHelper,
        \Magento\Catalog\Model\ProductFactory $productModelFactory,
        ModelMedia $model_media
    ) {
        $this->swatchHelper = $swatchHelper;
        $this->productModelFactory = $productModelFactory;
        $this->_model_media = $model_media;

        parent::__construct($context,$swatchHelper,$productModelFactory);
    }

    /**
     * Get product media by fallback:
     * 1stly by default attribute values
     * 2ndly by getting base image from configurable product
     *
     * @return string
     */
    public function execute()
    {
        $productMedia = [];
        if ($productId = 550) {
            $currentConfigurable = $this->productModelFactory->create()->load($productId);
            $attributes = array('color'=>7);
            if (!empty($attributes)) {
                $product = $this->getProductVariationWithMedia($currentConfigurable, $attributes);
            }
            if ((empty($product) || (!$product->getImage() || $product->getImage() == 'no_selection'))
                && isset($currentConfigurable)
            ) {
                $product = $currentConfigurable;
            }
            $resize_option = array();
            $productMedia = $this->_model_media->getProductMediaGallery($product, $resize_option);
        }

        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData($productMedia);
        return $resultJson;
    }

}
