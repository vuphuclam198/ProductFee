<?php
namespace AHT\ProductFee\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\QuoteRepository;

class SalesModelServiceQuoteSubmitBefore implements ObserverInterface
{
    /**
     * @var QuoteRepository
     */
    private $quoteRepository;

    /**
     * SalesModelServiceQuoteSubmitBefore constructor.
     *
     * @param QuoteRepository $quoteRepository
     */
    public function __construct(
        QuoteRepository $quoteRepository
    ) {
        $this->quoteRepository = $quoteRepository;
    }

    /**
     * @param EventObserver $observer
     * @return $this
     * @throws \Exception
     */
    public function execute(EventObserver $observer)
    {
        $order = $observer->getOrder();
        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $this->quoteRepository->get($order->getQuoteId());
        $order->setTotalsFee($quote->getTotalsFee());

        return $this;
    }
}