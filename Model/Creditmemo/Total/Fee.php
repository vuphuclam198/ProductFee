<?php
namespace AHT\ProductFee\Model\Creditmemo\Total;

class Fee extends \Magento\Sales\Model\Order\Creditmemo\Total\AbstractTotal
{
    /**
     * @param \Magento\Sales\Model\Order\Creditmemo $creditmemo
     * @return $this
     */
    public function collect(\Magento\Sales\Model\Order\Creditmemo $creditmemo)
    {

        $fee = $creditmemo->getOrder()->getTotalsFee();

        $creditmemo->setGrandTotal($creditmemo->getGrandTotal() + $fee); // 2 extra fee
        $creditmemo->setBaseGrandTotal($creditmemo->getBaseGrandTotal() + $fee);  // 2 extra fee

        return $this;
    }
}
