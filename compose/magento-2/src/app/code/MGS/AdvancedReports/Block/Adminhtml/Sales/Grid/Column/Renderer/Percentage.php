<?php

namespace MGS\AdvancedReports\Block\Adminhtml\Sales\Grid\Column\Renderer;

use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;

class Percentage extends AbstractRenderer
{
    public function __construct(\Magento\Backend\Block\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    public function render(\Magento\Framework\DataObject $row)
    {
        return round($row->getData($this->getColumn()->getIndex()), 1) . '%';
    }
}
