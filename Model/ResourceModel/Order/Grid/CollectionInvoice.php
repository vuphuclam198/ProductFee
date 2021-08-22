<?php
 
namespace Vendor\Module\Model\ResourceModel\Order\Grid;
 
use Magento\Sales\Model\ResourceModel\Order\Invoice\Grid\Collection as OriginalCollection;
 
class CollectionInvoice extends OriginalCollection{
 
    protected function _construct(){
 
        $this->addFilterToMap('created_at', 'main_table.created_at');
 
        $this->addFilterToMap('billing_country', 'soab.country_id');
        $this->addFilterToMap('billing_street', 'soab.street');
        $this->addFilterToMap('billing_city', 'soab.city');
        $this->addFilterToMap('billing_zipcode', 'soab.billing_zipcode');
        $this->addFilterToMap('billing_state', 'soabr.code');
 
        $this->addFilterToMap('shipping_country', 'soa.country_id');
        $this->addFilterToMap('shipping_street', 'soa.street');
        $this->addFilterToMap('shipping_city', 'soa.city');
        $this->addFilterToMap('shipping_zipcode', 'soa.shipping_zipcode');
        $this->addFilterToMap('shipping_state', 'soar.code');
 
        $this->addFilterToMap('tax_amount', 'so.base_tax_amount');
        $this->addFilterToMap('shipping_tax_amount', 'so.base_shipping_tax_amount');
        $this->addFilterToMap('discount_amount', 'so.base_discount_amount');
 
        parent::_construct();
 
    }
 
    protected function _renderFiltersBefore(){
 
        $this->getSelect()->joinLeft(
            ["so" => "sales_order"],
            'main_table.order_id = so.entity_id',
            array('base_tax_amount as tax_amount','base_shipping_tax_amount as shipping_tax_amount', 'base_discount_amount as discount_amount')
        )
        ->distinct();
 
        $this->getSelect()->joinLeft(
            ["soa" => "sales_order_address"],
            'so.shipping_address_id = soa.entity_id',
            array('street as shipping_street', 'city as shipping_city', 'postcode as shipping_zipcode', 'country_id as shipping_country')
        )
        ->distinct();
 
        $this->getSelect()->joinLeft(
            ["soab" => "sales_order_address"],
            'so.billing_address_id = soab.entity_id',
            array('street as billing_street', 'city as billing_city', 'postcode as billing_zipcode', 'country_id as billing_country')
        )
        ->distinct();
 
        $this->getSelect()->joinLeft(
            ["soar" => "directory_country_region"],
            'soa.region_id = soar.region_id',
            array('code as shipping_state')
        )
        ->distinct();
 
        $this->getSelect()->joinLeft(
            ["soabr" => "directory_country_region"],
            'soab.region_id = soabr.region_id',
            array('code as billing_state')
        )
        ->distinct();
 
        parent::_renderFiltersBefore();
    }
}