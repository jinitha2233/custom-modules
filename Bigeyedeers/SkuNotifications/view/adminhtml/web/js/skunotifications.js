/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

define([
        'jquery',
        'Magento_Ui/js/modal/modal'
    ], 
    function (
            $,
            modal
        ) {
            var options = {
                type: 'popup',
                responsive: true,
                innerScroll: true,
                title: 'Sku Notification',
                modalClass: 'sku-notification',
                buttons: [{
                    text: $.mage.__('OK'),
                    class: '',
                    click: function () {
                        this.closeModal();
                     }
                }]
            };

            var popup = modal(options, $('#sku-popup-modal'));
            $("#sku-popup-modal").modal('openModal');

        }
);