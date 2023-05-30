<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\CheckoutMessage\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface CheckoutMessageRepositoryInterface
{

    /**
     * Save CheckoutMessage
     * @param \Bigeyedeers\CheckoutMessage\Api\Data\CheckoutMessageInterface $checkoutmessage
     * @return \Bigeyedeers\CheckoutMessage\Api\Data\CheckoutMessageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Bigeyedeers\CheckoutMessage\Api\Data\CheckoutMessageInterface $checkoutmessage
    );

    /**
     * Retrieve CheckoutMessage
     * @param string $checkoutmessageId
     * @return \Bigeyedeers\CheckoutMessage\Api\Data\CheckoutMessageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($checkoutmessageId);

    /**
     * Retrieve CheckoutMessage matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Bigeyedeers\CheckoutMessage\Api\Data\CheckoutMessageSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete CheckoutMessage
     * @param \Bigeyedeers\CheckoutMessage\Api\Data\CheckoutMessageInterface $checkoutmessage
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Bigeyedeers\CheckoutMessage\Api\Data\CheckoutMessageInterface $checkoutmessage
    );

    /**
     * Delete CheckoutMessage by ID
     * @param string $checkoutmessageId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($checkoutmessageId);
}

