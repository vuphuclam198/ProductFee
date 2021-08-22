<?php
namespace AHT\ProductFee\Block\Sales\Order\Invoice;

class Total extends \Magento\Framework\View\Element\Template
{
 public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->setInitialFields();
    }
 
    public function setInitialFields()
    {
        if (!$this->getLabel()) {
            $this->setLabel(__('Order Packing Charges'));
        }
    }
 
    public function initTotals()
    {
        $this->getParentBlock()->addTotal(
            new \Magento\Framework\DataObject(
                [
                    'code' => 'fee',
                    'strong' => $this->getStrong(),
                    'value' => $this->getOrder()->getTotalFee(), // extension attribute field
                    'base_value' => $this->getOrder()->getCustom(),
                    'label' => __($this->getLabel()),
                ]
            ),
            $this->getAfter()
        );
        return $this;
    }
 
    public function getOrder()
    {
        return $this->getParentBlock()->getOrder();
    }
 
    public function getSource()
    {
        return $this->getParentBlock()->getSource();
    }
}
