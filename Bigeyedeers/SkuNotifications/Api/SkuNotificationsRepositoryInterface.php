<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\SkuNotifications\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface SkuNotificationsRepositoryInterface
{

    /**
     * Save SkuNotifications
     * @param \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsInterface $skuNotifications
     * @return \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsInterface $skuNotifications
    );

    /**
     * Retrieve SkuNotifications
     * @param string $skunotificationsId
     * @return \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($skunotificationsId);

    /**
     * Retrieve SkuNotifications matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete SkuNotifications
     * @param \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsInterface $skuNotifications
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsInterface $skuNotifications
    );

    /**
     * Delete SkuNotifications by ID
     * @param string $skunotificationsId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($skunotificationsId);
}

