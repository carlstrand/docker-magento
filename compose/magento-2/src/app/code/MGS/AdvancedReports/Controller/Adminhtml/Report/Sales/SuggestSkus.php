<?php

namespace MGS\AdvancedReports\Controller\Adminhtml\Report\Sales;

class SuggestSkus extends \Magento\Backend\App\Action
{
    protected $resultJsonFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    )
    {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
    }

    public function execute()
    {
        return $this->resultJsonFactory->create()->setData([
            ['value' => '1', 'label' => 'Test']
        ]);
    }
}
