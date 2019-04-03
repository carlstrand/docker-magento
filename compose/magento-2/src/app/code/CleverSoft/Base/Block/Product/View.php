<?php
/**
 * @category    CleverSoft
 * @package     CleverBase
 * @copyright   Copyright © 2017 CleverSoft., JSC. All Rights Reserved.
 * @author 		ZooExtension.com
 * @email       magento.cleversoft@gmail.com
 */
/**
 * Page header block
 */

namespace CleverSoft\Base\Block\Product;

use CleverSoft\Base\Helper\Data as HelperData;
use CleverSoft\Base\Helper\Template\Catalog\Product\View as HelperTemplateProductView;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;

class View extends \Magento\Framework\View\Element\Template
{
    /**
     * Theme helper
     *
     * @var HelperData
     */
    protected $theme;

    /**
     * Product view helper
     *
     * @var HelperTemplateProductView
     */
    protected $helperProductView;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @param Context $context
     * @param HelperData $helperData
     * @param HelperTemplateProductView $helperTemplateProductView
     * @param array $data
     */
    public function __construct(
        Context $context,
        HelperData $helperData,
        HelperTemplateProductView $helperTemplateProductView,
        Registry $registry,
        array $data = []
    ) {
        $this->theme = $helperData;
        $this->helperProductView = $helperTemplateProductView;
        $this->registry = $registry;

        parent::__construct($context, $data);
    }

   /**
     * Get helper
     *
     * @return HelperData
     */
    public function getHelperTheme()
    {
        return $this->theme;
    }

   /**
     * Get helper
     *
     * @return HelperTemplateProductView
     */
    public function getHelperProductView()
    {
        return $this->helperProductView;
    }

    /**
     * Retrieve currently viewed product object
     *
     * @return \Magento\Catalog\Model\Product
     */
    public function getProduct()
    {
        return $this->registry->registry('product');
    }

}
