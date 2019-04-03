<?php

namespace MGS\AdvancedReports\Controller\Adminhtml\Report;

abstract class Sales extends AbstractReport
{
    public function _initAction()
    {
        parent::_initAction();
        $this->_addBreadcrumb(__('Sales'), __('Sales'));
        return $this;
    }

    protected function _isAllowed()
    {
        switch ($this->getRequest()->getActionName()) {
            case 'country':
                return $this->_authorization->isAllowed('MGS_AdvancedReports::advancedreports_salesbycountry');
                break;
            case 'group':
                return $this->_authorization->isAllowed('MGS_AdvancedReports::advancedreports_salesbygroup');
                break;
            case 'coupon':
                return $this->_authorization->isAllowed('MGS_AdvancedReports::advancedreports_salesbycoupon');
                break;
            case 'product':
                return $this->_authorization->isAllowed('MGS_AdvancedReports::advancedreports_salesbyproduct');
                break;
            case 'hour':
                return $this->_authorization->isAllowed('MGS_AdvancedReports::advancedreports_salesbyhour');
                break;
            case 'day':
                return $this->_authorization->isAllowed('MGS_AdvancedReports::advancedreports_salesbyday');
                break;
            case 'newandreturning':
                return $this->_authorization->isAllowed('MGS_AdvancedReports::advancedreports_salesbynewandreturning');
                break;
            default:
                return $this->_authorization->isAllowed('MGS_AdvancedReports::advancedreports');
                break;
        }
    }
}
