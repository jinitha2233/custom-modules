/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/* global AdminOrder */
define([
    'jquery',
    'Magento_Ui/js/modal/modal',
    'Magento_Sales/order/create/scripts',
], function ($, modal) {
    'use strict';

    AdminOrder.prototype.submit = function(){
        console.log("override submit called");

        var options = {
                type: 'popup',
                responsive: true,
                innerScroll: true,
                title: 'Have you confirmed/captured the following details:',
                modalClass: 'checkout-message-modal',
                buttons: [{
                    text: $.mage.__('Cancel'),
                    class: 'action-default cancel',
                    click: function () {
                        this.closeModal();
                    }},
                    {
                    text: $.mage.__('OK'),
                    class: 'action-default primary',
                    click: function () {
                        this.closeModal();
                        var $editForm = $('#edit_form'),
                        beforeSubmitOrderEvent;

                        if ($editForm.valid()) {
                            $editForm.trigger('processStart');
                            beforeSubmitOrderEvent = jQuery.Event('beforeSubmitOrder');
                            $editForm.trigger(beforeSubmitOrderEvent);
                            if (beforeSubmitOrderEvent.result !== false) {
                                $editForm.trigger('submitOrder');
                            }
                        }
                    }
                }]
            };
        console.log("popup defined");
        var popup = modal(options, $('#checkout-popup-modal'));
        $("#checkout-popup-modal").modal('openModal');
        console.log("popup end");
    }
});