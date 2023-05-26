Bigeyedeers InventoryUpdate Module
==============================

This module is to update the inventory via csv file

Steps to install this module
Step1 : Place this module folder inside your app/code
Step2 : Make sure that you are in the developer mode. Install module by running "bin/magento setup:upgrade" Command.
step3 : Run static content deployment. bin/magento setup:static-content:deploy -f.
Step4: Load your website and login to your admin panel. Stores -> Configuration Now you can see "Inventory Update" sub menu under "BigEyeDeers" menu.
step5: Place the "stock_update.csv" file inside var/import.
Step5: Add the cron expression in the "Add Cron Expression" field as per the frequency you want to run the cron. By default it is set to "*/10 * * * *". Which means cron runs every 10 minutes and updates the inventory from var/import/stock_update.csv file.

