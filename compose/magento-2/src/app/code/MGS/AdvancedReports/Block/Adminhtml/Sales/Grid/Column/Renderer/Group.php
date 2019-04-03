<?php

namespace MGS\AdvancedReports\Block\Adminhtml\Sales\Grid\Column\Renderer;

use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
use Magento\Customer\Model\Group as CustomerGroup;

class Group extends AbstractRenderer
{
    protected $group;

    public function __construct(\Magento\Backend\Block\Context $context, CustomerGroup $group, array $data = [])
    {
        $this->group = $group;
        parent::__construct($context, $data);
    }

    public function render(\Magento\Framework\DataObject $row)
    {
        if ($data = $row->getData($this->getColumn()->getIndex())) {
            return $this->group->load($data)->getCode();
        }
        return $row->getData($this->getColumn()->getIndex());
    }
}
