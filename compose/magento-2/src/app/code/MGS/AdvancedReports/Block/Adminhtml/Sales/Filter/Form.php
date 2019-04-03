<?php

namespace MGS\AdvancedReports\Block\Adminhtml\Sales\Filter;

class Form extends \Magento\Reports\Block\Adminhtml\Filter\Form
{
    protected $_orderConfig;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Sales\Model\Order\ConfigFactory $orderConfig,
        array $data = []
    )
    {
        $this->_orderConfig = $orderConfig;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        parent::_prepareForm();
        $form = $this->getForm();
        $htmlIdPrefix = $form->getHtmlIdPrefix();
        $fieldset = $this->getForm()->getElement('base_fieldset');
        if (is_object($fieldset) && $fieldset instanceof \Magento\Framework\Data\Form\Element\Fieldset) {
            $fieldset->addField(
                'date_used',
                'select',
                [
                    'name' => 'date_used',
                    'options' => [
                        'custom' => __('Custom Date'),
                        'today' => __('Today'),
                        'yesterday' => __('Yesterday'),
                        'last_7_days' => __('Last 7 Days'),
                        'last_week' => __('Last Week (Monday - Sunday)'),
                        'last_business_week' => __('Last Business Week (Monday - Friday)'),
                        'this_month' => __('This Month'),
                        'last_month' => __('Last Month'),
                        'last_3_months' => __('Last 3 Months'),
                        'last_6_months' => __('Last 6 Months'),
                        'this_year' => __('This Year')
                    ],
                    'label' => __('Date Used'),
                    'title' => __('Date Used')
                ],
                'store_ids'
            );
            $statuses = $this->_orderConfig->create()->getStatuses();
            $values = [];
            foreach ($statuses as $code => $label) {
                $values[] = ['label' => __($label), 'value' => $code];
            }
            $fieldset->addField(
                'show_order_statuses',
                'select',
                [
                    'name' => 'show_order_statuses',
                    'label' => __('Order Status'),
                    'options' => ['0' => __('Any'), '1' => __('Specified')],
                    'note' => __('Applies to Any of the Specified Order Statuses except canceled orders')
                ],
                'to'
            );
            $fieldset->addField(
                'order_statuses',
                'multiselect',
                ['name' => 'order_statuses', 'values' => $values, 'display' => 'none'],
                'show_order_statuses'
            );
            if ($this->getFieldVisibility('show_order_statuses') && $this->getFieldVisibility('order_statuses')) {
                $this->setChild(
                    'form_after',
                    $this->getLayout()->createBlock(
                        'Magento\Backend\Block\Widget\Form\Element\Dependence'
                    )->addFieldMap(
                        "{$htmlIdPrefix}show_order_statuses",
                        'show_order_statuses'
                    )->addFieldMap(
                        "{$htmlIdPrefix}order_statuses",
                        'order_statuses'
                    )->addFieldDependence(
                        'order_statuses',
                        'show_order_statuses',
                        '1'
                    )
                );
            }
            $fieldset->addField(
                'show_actual_columns',
                'select',
                [
                    'name' => 'show_actual_columns',
                    'options' => ['1' => __('Yes'), '0' => __('No')],
                    'label' => __('Show Actual Values')
                ]
            );
        }
        return $this;
    }
}
