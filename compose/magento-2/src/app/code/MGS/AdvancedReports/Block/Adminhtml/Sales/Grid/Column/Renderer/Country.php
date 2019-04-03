<?php

namespace MGS\AdvancedReports\Block\Adminhtml\Sales\Grid\Column\Renderer;

use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
use Magento\Directory\Model\Country as CountryModel;

class Country extends AbstractRenderer
{
    protected $country;

    public function __construct(\Magento\Backend\Block\Context $context, CountryModel $country, array $data = [])
    {
        $this->country = $country;
        parent::__construct($context, $data);
    }

    public function render(\Magento\Framework\DataObject $row)
    {
        if ($data = $row->getData($this->getColumn()->getIndex())) {
            return $this->country->loadByCode($data)->getName();
        }
        return $row->getData($this->getColumn()->getIndex());
    }
}
