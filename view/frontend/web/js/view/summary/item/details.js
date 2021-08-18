define(
    [
        'uiComponent'
    ],
 
    function (Component) {
 
        "use strict";
 
        var quoteItemData = window.checkoutConfig.quoteItemData;
 
        return Component.extend({
 
            defaults: {
 
                template: 'AHT_ProductFee/summary/item/details'
 
            },
 
            quoteItemData: quoteItemData,
 
            getValue: function(quoteItem) {
 
                return quoteItem.name;
 
            },
 
            getFee: function(quoteItem) {
 
                var item = this.getItem(quoteItem.item_id);
                
                if(item.fee_value){
 
                    return item.fee_label + ' : ' + item.fee_value;
 
                }else{
 
                    return '';
 
                }
 
            },
 
            getItem: function(item_id) {
 
                var itemElement = null;
 
                _.each(this.quoteItemData, function(element, index) {
 
                    if (element.item_id == item_id) {
 
                        itemElement = element;
 
                    }
 
                });
 
                return itemElement;
 
            }
 
        });
 
    }
 
);