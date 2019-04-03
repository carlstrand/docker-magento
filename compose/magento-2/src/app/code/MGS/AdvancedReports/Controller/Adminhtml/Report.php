<?php

namespace MGS\AdvancedReports\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Response\Http\FileFactory;

abstract class Report extends Action
{
    protected $_fileFactory;

    public function __construct(
        Context $context,
        FileFactory $fileFactory
    )
    {
        $this->_fileFactory = $fileFactory;
        parent::__construct($context);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('MGS_AdvancedReports::advancedreports');
    }
}
