Bigeyedeers_InventoryUpdate Module
==============================

Bigeyedeers_InventoryUpdate module is to update the inventory via csv file

Steps to install
==============================

Step1 : Place the Bigeyedeers/InventoryUpdate module folder inside your app/code
Step2 : Make sure that you are in the developer mode. Install module by running "bin/magento setup:upgrade" Command.
step3 : Run static content deployment. bin/magento setup:static-content:deploy -f.
Step4 : Flush caches. bin/magento cache:flush.

Steps to Configure and Use
==============================
Step1 : Load your website and login to your admin panel. Stores -> Configuration Now you can see "Inventory Update" sub menu under "BigEyeDeers" menu.
step2 : Place the "stock_update.csv" file inside var/import.
Step3 : Add the cron expression in the "Add Cron Expression" field as per the frequency you want to run the cron. By default it is set to "*/10 * * * *". Which means cron runs every 10 minutes and updates the inventory from var/import/stock_update.csv file.

