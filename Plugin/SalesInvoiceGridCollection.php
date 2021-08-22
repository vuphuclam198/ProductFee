<?php

namespace AHT\ProductFee\Plugin;

use Magento\Framework\View\Element\UiComponent\DataProvider\CollectionFactory;
use Magento\Sales\Model\ResourceModel\Order\Invoice\Collection as SalesOrderInvoiceGridCollection;

class SalesInvoiceGridCollection
{
    const SALES_ORDER_INVOICE_GRID_DATA_SOURCE = 'sales_order_invoice_grid_data_source';

    private $collection;

    public function __construct(SalesOrderInvoiceGridCollection $collection)
    {
        $this->collection = $collection;
    }

    public function aroundGetReport(CollectionFactory $subject, \Closure $proceed, $requestName)
    {
        $result = $proceed($requestName);

        if (self::SALES_ORDER_INVOICE_GRID_DATA_SOURCE == $requestName) {
            if ($result instanceof $this->collection) {
                $select = $this->collection->getSelect();
                $select->joinLeft(
                    ['invoice' => $this->collection->getTable('sales_invoice')],
                    'main_table.entity_id = invoice.entity_id',
                    [
                        'total_fee' => 'invoice.entity_id'
                    ]
                );

                return $this->collection;
            }
        }

        return $result;
    }
}