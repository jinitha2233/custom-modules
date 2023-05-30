Bigeyedeers_CheckoutMessage Module
==============================

Bigeyedeers_CheckoutMessage module is to show "custom notification" on the admin panel when submitting an order.

Steps to Install
==============================

Step1 : Place the Bigeyedeers/CheckoutMessage module folder inside your app/code
Step2 : Make sure that you are in the developer mode. Install module by running "bin/magento setup:upgrade" Command.
step3 : Run static content deployment. bin/magento setup:static-content:deploy -f.
Step4 : Flush caches. bin/magento cache:flush.

Steps to Configure and Use
==============================

Step1 : In the admin panel. Go to BED->Checkout Messages-> Add New Checkout Message. Add you custom messages.
Step2 : Add your custom message in the  "Checkout Message content" field. Then select the status as Enabled then Save the checkout message.
        e.g : Make sure that you have filled the following informations
            1. Customer name
            2. Customer e-mail
            3. Customer address
Step3 : In the admin create new order Sales->Orders->Create New Order
Step4 : Add product and fill all the required fields and submit the Checkout. Now you can see the popup with your custom checkout message.
