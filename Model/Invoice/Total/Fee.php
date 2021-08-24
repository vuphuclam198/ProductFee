<?php
namespace AHT\ProductFee\Model\Invoice\Total;

class Fee extends \Magento\Sales\Model\Order\Invoice\Total\AbstractTotal
{
    /**
     * @param \Magento\Sales\Model\Order\Invoice $invoice
     * @return $this
     */
    public function collect(\Magento\Sales\Model\Order\Invoice $invoice)
    {

        $fee = $invoice->getOrder()->getTotalsFee();

        $invoice->setGrandTotal($invoice->getGrandTotal() + $fee); // 2 extra fee
        $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() + $fee);  // 2 extra fee

        return $this;
    }
}
