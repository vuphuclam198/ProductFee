<?php
namespace AHT\ProductFee\Model\Total;

use Laminas\Console\Prompt\Number;

class Fee extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
   /**
     * Collect grand total address amount
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return $this
     */
    protected $quoteValidator = null; 

    /**
     * @param \Magento\Catalog\Model\ResourceModel\ProductFactory
     */
    private $_productFactory;

    public function __construct(\Magento\Quote\Model\QuoteValidator $quoteValidator,
        \Magento\Catalog\Model\ProductFactory $productFactory)
    {
        $this->quoteValidator = $quoteValidator;
        $this->_productFactory = $productFactory;
    }
  public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        
        $items = $shippingAssignment->getItems();
        if (!count($items)) {
            return $this;
        }

        parent::collect($quote, $shippingAssignment, $total);

      $quoteItem =  $quote->getAllVisibleItems();
      $sum = 0;
      
      foreach ($quoteItem as $key => $value) {
         $productId = $value->getProductId();
         $product = $this->_productFactory->create()->load($productId);
         $productFee = $product->getProductFee();
         $sum += $productFee;
      }

    //   $exist_amount = 0; //$quote->getFee(); 
    //     $fee = 99; //Excellence_Fee_Model_Fee::getFee();
        $quote->setTotalsFee($sum);
        $balance = $sum;

        $total->setTotalAmount('fee', $balance);
        $total->setBaseTotalAmount('fee', $balance);
        $total->setFee($balance);
        $total->setBaseFee($balance);

        // $total->setGrandTotal($total->getGrandTotal() + $balance);
        $total->setBaseGrandTotal($total->getBaseGrandTotal() );


        return $this;
    } 

    protected function clearValues(Address\Total $total)
    {
        $total->setTotalAmount('subtotal', 0);
        $total->setBaseTotalAmount('subtotal', 0);
        $total->setTotalAmount('tax', 0);
        $total->setBaseTotalAmount('tax', 0);
        $total->setTotalAmount('discount_tax_compensation', 0);
        $total->setBaseTotalAmount('discount_tax_compensation', 0);
        $total->setTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setBaseTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setSubtotalInclTax(0);
        $total->setBaseSubtotalInclTax(0);
    }
    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param Address\Total $total
     * @return array|null
     */
    /**
     * Assign subtotal amount and label to address object
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param Address\Total $total
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        $quoteItem =  $quote->getAllVisibleItems();
        $sum = 0;
        foreach ($quoteItem as $key => $value) {
           $productId = $value->getProductId();
           $product = $this->_productFactory->create()->load($productId);
           $productFee = $product->getProductFee();
          $sum += $productFee;
        }
        
        return [
            'code' => 'fee',
            'title' => 'Fee',
            'value' => $sum
        ];
    }

    /**
     * Get Subtotal label
     *
     * @return \Magento\Framework\Phrase
     */
    public function getLabel()
    {
        return __('Fee');
    }
}
