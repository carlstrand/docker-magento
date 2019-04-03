<?php

namespace MGS\AdvancedReports\Block\Adminhtml\Sales\Grid\Column\Renderer;

use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;

class Coupon extends AbstractRenderer
{
    public function __construct(\Magento\Backend\Block\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    public function render(\Magento\Framework\DataObject $row)
    {
        if ($data = $row->getData($this->getColumn()->getIndex())) {
            return $data;
        }
        return __('Not set');
    }
}
