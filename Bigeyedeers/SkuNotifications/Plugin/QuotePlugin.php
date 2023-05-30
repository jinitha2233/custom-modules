<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\SkuNotifications\Plugin;

class QuotePlugin{
    /**
     * @var \Bigeyedeers\SkuNotifications\Model\ResourceModel\SkuNotifications\CollectionFactory
     */
	protected $skuNotifications;

	public function __construct(
        \Bigeyedeers\SkuNotifications\Model\ResourceModel\SkuNotifications\CollectionFactory $skuNotifications,
        \Magento\Framework\Session\SessionManagerInterface $sessionManager
    ) {
        $this->skuNotifications = $skuNotifications;
        $this->sessionManager = $sessionManager;
    }

    /**
     * Set the session variable for sku notification message
     * @return array
     */
	public function afterAddItem(\Magento\Quote\Model\Quote $subject, $result, \Magento\Quote\Model\Quote\Item $item)
	{
		$quoteItem = $item->getProduct();
        $everySku = $this->skuNotifications->create()
                    ->addFieldToFilter('every_sku', array('eq' => 1))
                    ->addFieldToFilter('status', array('eq' => 1));

        $skuNotifications = $this->skuNotifications->create()
                                        ->addFieldToFilter('sku', array('eq' => $quoteItem->getSku()))
                                        ->addFieldToFilter('status', array('eq' => 1));

        if($everySku) {
            $skuNotificationIds = array_unique(array_merge($everySku->getAllIds(), $skuNotifications->getAllIds()));
            if($skuNotificationIds) {
                $skuNotifications = $this->skuNotifications->create()->addFieldToFilter('id', ['in' => $skuNotificationIds]);
            }
        }


        $arrayMessage = $this->sessionManager->getMySession();

        if(count($skuNotifications) > 0):
            foreach ($skuNotifications as $_item) :
                $arrayMessage[$_item['sku']] = $_item['content'];
            endforeach;
        endif;
        $this->sessionManager->setMySession($arrayMessage);

		return $result;
	}

}

