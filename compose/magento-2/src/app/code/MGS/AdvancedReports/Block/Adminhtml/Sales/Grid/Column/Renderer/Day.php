<?php

namespace MGS\AdvancedReports\Block\Adminhtml\Sales\Grid\Column\Renderer;

use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;

class Day extends AbstractRenderer
{
    protected $country;

    public function __construct(\Magento\Backend\Block\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    public function render(\Magento\Framework\DataObject $row)
    {
        if ($data = $row->getData($this->getColumn()->getIndex())) {
            if ($data == 1) {
                return __('Sunday');
            }
            if ($data == 2) {
                return __('Monday');
            }
            if ($data == 3) {
                return __('Tuesday');
            }
            if ($data == 4) {
                return __('Wednesday');
            }
            if ($data == 5) {
                return __('Thursday');
            }
            if ($data == 6) {
                return __('Friday');
            }
            if ($data == 7) {
                return __('Saturday');
            }
        }
        return $row->getData($this->getColumn()->getIndex());
    }
}
