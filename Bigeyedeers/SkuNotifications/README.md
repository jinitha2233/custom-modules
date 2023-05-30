Bigeyedeers_SkuNotifications Module
==============================

Bigeyedeers_SkuNotifications module is to show "custom notification" on the admin panel when adding specific product/Each product to the cart.

Steps to Install
==============================

Step1 : Place the Bigeyedeers/SkuNotifications module folder inside your app/code
Step2 : Make sure that you are in the developer mode. Install module by running "bin/magento setup:upgrade" Command.
step3 : Run static content deployment. bin/magento setup:static-content:deploy -f.
Step4 : Flush caches. bin/magento cache:flush.

Steps to Configure and Use
==============================

Step1 : In the admin panel. Go to BED->Sku Notifications-> Add New CSku Notifications.
        Enter the all the fields
        Title : Title of the Skunotification
        Status : Set the status enabled
        Content : Enter the Notification message for the product which you want to add.
        Every SKU : if you mark it to checked, this specific notification message will be shown for all the product when it is going to the cart.
                    if you leave it as un checked, this notification will be shown only for the product which you specify SKU.
        sku : Enter the product "SKU" which you want to add this notification when adding to cart.
Step2 : Save SKU Notification.
Step3 : In the admin create new order Sales->Orders->Create New Order
step4 : When you add the specific product which SKU is available in the Sku Notification grid. Then it shows the notification popup on add to cart.

