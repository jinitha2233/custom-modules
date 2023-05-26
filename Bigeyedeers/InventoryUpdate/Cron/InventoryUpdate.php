<?php
/**
 * Copyright © Bigeyedeers. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Bigeyedeers\InventoryUpdate\Cron;

use Bigeyedeers\InventoryUpdate\Logger\Logger;
use Magento\CatalogInventory\Api\StockRegistryInterface;

class InventoryUpdate
{

    /**
     * @var \Bigeyedeers\InventoryUpdate\Logger\Logger
     */
    protected $logger;

    /**
     * @var \Magento\CatalogInventory\Api\StockRegistryInterface
     */
    protected $stockRegistry;

    /**
     * @var \Magento\CatalogInventory\Api\StockRegistryInterface
     */
    public $cronCollection;


    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $dateTime;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */

    private $productRepository;

    /**
     * @param \Bigeyedeers\InventoryUpdate\Logger\Logger $logger
     * @param \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Bigeyedeers\InventoryUpdate\Model\ResourceModel\Cron\CollectionFactory $cronCollection
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
     * @param \Magento\Framework\Filesystem\Driver\File $fileDriver
     * @param \Magento\Framework\App\State $appState
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     */
    public function __construct(
        Logger $logger,
        StockRegistryInterface $stockRegistry,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Bigeyedeers\InventoryUpdate\Model\ResourceModel\Cron\CollectionFactory $cronCollection,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime,
        \Magento\Framework\Filesystem\Driver\File $fileDriver,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    ){
        $this->logger            = $logger;
        $this->stockRegistry     = $stockRegistry;
        $this->scopeConfig       = $scopeConfig;
        $this->cronCollection    = $cronCollection;
        $this->dateTime          = $dateTime;
        $this->fileDriver        = $fileDriver;
        $this->productRepository = $productRepository;
    }

    /**
     * Write to inventory_logger.log
     *
     * @return void
     */
    public function execute()
    {
        $this->logger->info('Inventry update - cron job started executing...');

        // check if the cron job is enabled
        if ($this->isCronJobEnabled()) {
            $lastRunTime          = $this->getLastRunTime('inventory_update_cronjob');
            $currentScheduledTime = $this->getCurrentScheduledTime('inventory_update_cronjob');

            // check last successful run time to avoid parellel execution
            if ($currentScheduledTime > $lastRunTime) {
                $filePath = 'var/import/stock_update.csv';

                // check if the csv file exists
                if ($this->fileDriver->isExists($filePath)) {
                    $lastCsvModified = $this->getCsvLastModified($filePath);

                    // check if the csv file is modified after the last successful run to avoid executing the non modified file again
                    if ($lastCsvModified > $lastRunTime) {
                        $file = fopen($filePath, 'r');

                        $isFileNotempty = $this->isNotEmpty($filePath);

                        // check whether the file is empty
                        if ($isFileNotempty) {

                            // enter the number of data fields you require the product row inside the CSV file to contain
                            $required_data_fields = 2;

                            $header = fgetcsv($file, 1000, "|"); // get data headers and skip 1st row

                            // $this->logger->info('csv header : ');
                            // $this->logger->info(print_r($header, true));

                            $rowNumber = 1;
                            while ($row = fgetcsv($file, 1000, "|")) {
                                // $this->logger->info('csv row : ');
                                // $this->logger->info(print_r($row, true));
                                try {
                                    $data_count = count($row);

                                    // check whether the number of columns are valid
                                    if ($data_count < $required_data_fields) {
                                        $this->logger->warning("Skipping product sku. Not enough data to import in row " . $rowNumber);
                                        $rowNumber++;
                                        continue;
                                    }


                                    $data = array();
                                    $data = array_combine($header, $row);

                                    $sku = $data['sku'];

                                    $quantity = trim($data['quantity']);
                                }
                                catch (\Exception $e) {
                                    $this->logger->info(__LINE__.$e->getMessage());
                                }

                                try {
                                    $product = $this->productRepository->get($sku);
                                }
                                catch (\Exception $e) {
                                    $this->logger->warning(__LINE__."Invalid product SKU: " . $sku);
                                    continue;
                                }

                                try {
                                    $stockItem = $this->stockRegistry->getStockItemBySku($sku);
                                }
                                catch (\Exception $e) {
                                    $this->logger->warning(__LINE__.$e->getMessage());
                                    continue;
                                }

                                try {
                                    if ($stockItem->getQty() != $quantity) {
                                        $stockItem->setQty($quantity);
                                        if ($quantity > 0) {
                                            $stockItem->setIsInStock(1);
                                        } else {
                                            $stockItem->setIsInStock(0);
                                        }
                                        $this->stockRegistry->updateStockItemBySku($sku, $stockItem);
                                    }
                                }
                                catch (\Exception $e) {
                                    $this->logger->info(__LINE__ . $e->getMessage());
                                }
                                $rowNumber++;
                            }
                            fclose($file);
                            $this->logger->info("Inventory has been updated successfully!");
                        } else {
                            $this->logger->warning('file is empty or does not have any data rows');
                            throw new \Exception('file is empty or does not have any data rows');
                        }

                    } else {
                        $this->logger->info("Data in file is the same as the last successful update.");
                    }
                } else {
                    $this->logger->warning('file does not exists in the var/import.');
                    throw new \Exception('file does not exists in the var/import.');
                }
            } else {
                $this->logger->warning('Job skipped due to overrun of previous job');
                throw new \Exception('Job skipped due to overrun of previous job.');
            }
        } else {
            $this->logger->info('Inventory update Cron job is disabled');
            throw new \Exception('Inventory update Cron job is disabled');
        }
    }

    /**
     * check whether the cron job is enabled
     * @return int
     */
    public function isCronJobEnabled()
    {
        $isEnable = $this->scopeConfig->getValue('inventory_update/general/enable_inventory', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        return $isEnable;
    }

    /**
     * check whether the csv file has content
     * @return bool
     */
    public function isNotEmpty($filePath)
    {
        $fp       = file($filePath);
        $rowCount = count($fp);
        if ($rowCount > 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * get the last successful run time of the cron job
     * @return string
     */
    public function getLastRunTime($croncode)
    {
        try {
            $currentRunningJob = $this->cronCollection->create()->addFieldToFilter('job_code', $croncode)->addFieldToFilter('status', 'success')->setOrder('finished_at', 'DESC')->setPageSize(1);
            if ($currentRunningJob) {
                $finishedAtTime = $currentRunningJob->getFirstItem()->getFinishedAt();
                return $finishedAtTime;
            } else {
                $this->logger->info($croncode . "job is not listed in the cron_schedule table");
            }
        }
        catch (\Exception $e) {
            $this->logger->info(__LINE__ . $e->getMessage());
        }
    }

    /**
     * get the last modified time of the csv file to be imported
     * @return string
     */
    public function getCsvLastModified($filePath)
    {
        $fileModified     = filemtime($filePath);
        $lastFileModified = $this->dateTime->gmtDate($format = null, $fileModified);
        return $lastFileModified;
    }

    /**
     * get scheduled time of current job
     * @return string
     */
    public function getCurrentScheduledTime($croncode)
    {
        $currentRunningJob = $this->cronCollection->create()->addFieldToFilter('job_code', $croncode)->addFieldToFilter('status', 'running')->setPageSize(1);

        return $currentRunningJob->getFirstItem()->getScheduledAt();
    }
}
