<?php

namespace MGS\AdvancedReports\Controller\Adminhtml\Report\Sales;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

class ExportSalesReportExcel extends \MGS\AdvancedReports\Controller\Adminhtml\Report\Sales
{
    public function execute()
    {
        $fileName = 'sales_report.xml';
        $grid = $this->_view->getLayout()->createBlock('MGS\AdvancedReports\Block\Adminhtml\Sales\Report\Grid');
        $this->_initReportAction($grid);
        return $this->_fileFactory->create($fileName, $grid->getExcelFile($fileName), DirectoryList::VAR_DIR);
    }
}
