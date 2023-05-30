define(
    [
        'jquery',
        'prototype'
    ],
    function (jQuery) {
        'use strict';

        return function () {
            window.AdminOrder.prototype.productGridAddSelected = function () {
                if (this.productGridShowButton) {
                    Element.show(this.productGridShowButton);
                }
                var area = ['sidebar', 'search', 'items', 'shipping_method', 'totals', 'giftmessage','billing_method'];
                // prepare additional fields and filtered items of products
                var fieldsPrepare = {};
                var itemsFilter = [];
                var products = this.gridProducts.toObject();
                for (var productId in products) {
                    itemsFilter.push(productId);
                    var paramKey = 'item['+productId+']';
                    for (var productParamKey in products[productId]) {
                        paramKey += '['+productParamKey+']';
                        fieldsPrepare[paramKey] = products[productId][productParamKey];
                    }
                }
                this.productConfigureSubmit('product_to_add', area, fieldsPrepare, itemsFilter);
                productConfigure.clean('quote_items');
                this.hideArea('search');
                this.gridProducts = $H({});
            };
        };
    }
);
