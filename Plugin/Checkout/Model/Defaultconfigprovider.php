<?php
namespace AHT\ProductFee\Plugin\Checkout\Model;
use Magento\Checkout\Model\Session as CheckoutSession;
 
class Defaultconfigprovider
 
{
    /**
 
     * @var CheckoutSession
 
     */
 
    protected $checkoutSession;
 
    /**
 
     * Constructor
 
     *
 
     * @param CheckoutSession $checkoutSession
 
     */
 
    public function __construct(
        CheckoutSession $checkoutSession
    ) {
        $this->checkoutSession = $checkoutSession;
    }
 
    public function afterGetConfig(
        \Magento\Checkout\Model\DefaultConfigProvider $subject,
        array $result
 
    ) {
        $items = $result['totalsData']['items'];
 
        foreach ($items as $index => $item) {
            $quoteItem = $this->checkoutSession->getQuote()->getItemById($item['item_id']);
            $result['quoteItemData'][$index]['fee_value'] = $quoteItem->getProduct()->getResource()->getAttribute('product_fee')->getFrontend()->getValue($quoteItem->getProduct());
            $result['quoteItemData'][$index]['fee_label'] = $quoteItem->getProduct()->getResource()->getAttribute('product_fee')->getFrontend()->getLabel($quoteItem->getProduct());
        }

        return $result;
 
    }
 
}