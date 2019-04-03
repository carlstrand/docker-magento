<?php

namespace MGS\AdvancedReports\Controller\Adminhtml\Report\Sales;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

class ExportSalesByHourCsv extends \MGS\AdvancedReports\Controller\Adminhtml\Report\Sales
{
    public function execute()
    {
        $fileName = 'sales_by_hour.csv';
        $grid = $this->_view->getLayout()->createBlock('MGS\AdvancedReports\Block\Adminhtml\Sales\Hour\Grid');
        $this->_initReportAction($grid);
        return $this->_fileFactory->create($fileName, $grid->getCsvFile(), DirectoryList::VAR_DIR);
    }
}
