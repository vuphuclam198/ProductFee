<?php
namespace AHT\ProductFee\Observer;

class PaymentCartCollectItensAndAmounts implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @param \Magento\Checkout\Model\Session
     */
    private $_checkout;

    public function __construct(
        \Magento\Checkout\Model\Session $checkout
    )
    {
        $this->_checkout = $checkout;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Payment\Model\Cart $cart */
        $cart = $observer->getEvent()->getCart();
        $quote = $this->_checkout->getQuote();
        
        $address = $quote->getIsVirtual() ? $quote->getBillingAddress() : $quote->getShippingAddress();
        if ($customAmount = $quote->getTotalsFee())
        {
          $cart->addCustomItem(__('Fee'), 1, -1.00 * -$quote->getTotalsFee(), 'totals_fee');
        }
    }
}