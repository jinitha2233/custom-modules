Bigeyedeers_SidebarAddons Module
==============================

Bigeyedeers_SidebarAddons module is to display the Related Products, Up-Sells, Cross-Sells, and Addons on the sidebar of the admin order create page.
Steps to install
==============================

Step1 : Place the Bigeyedeers/SidebarAddons module folder inside your app/code
Step2 : Make sure that you are in the developer mode. Install module by running "bin/magento setup:upgrade" Command.
step3 : Run static content deployment. bin/magento setup:static-content:deploy -f.
Step4 : Flush caches. bin/magento cache:flush.

Steps to Configure and Use
==============================

Step1: In the admin panel got to Catalog->products->Select any product which you want to add Addons.
Step2: Open the "Related Products, Up-Sells, Cross-Sells, and Addons" section. Click on "Add Addon Products". Add Related Product or any Type from the list then Save the product.
Step3: In the admin Create a new order. Go to Sales->Orders->Create New Order
Step4: In the Admin Sales order page you can see the Related Products, Up-Sells, Cross-Sells, and Addons in the left sidebar. When you add specific product to the cart which has any linked type product it updates on the left sidebar.
