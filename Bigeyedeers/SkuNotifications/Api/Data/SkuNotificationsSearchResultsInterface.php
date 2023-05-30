<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\SkuNotifications\Api\Data;

interface SkuNotificationsSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get SkuNotifications list.
     * @return \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsInterface[]
     */
    public function getItems();

    /**
     * Set title list.
     * @param \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

