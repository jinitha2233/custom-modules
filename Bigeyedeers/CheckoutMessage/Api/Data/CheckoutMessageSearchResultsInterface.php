<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\CheckoutMessage\Api\Data;

interface CheckoutMessageSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get CheckoutMessage list.
     * @return \Bigeyedeers\CheckoutMessage\Api\Data\CheckoutMessageInterface[]
     */
    public function getItems();

    /**
     * Set title list.
     * @param \Bigeyedeers\CheckoutMessage\Api\Data\CheckoutMessageInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

