<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\CheckoutMessage\Api\Data;

interface CheckoutMessageInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const ID = 'id';
    const MESSAGE = 'Message';
    const STATUS = 'status';

    /**
     * Get id
     * @return string|null
     */
    public function getId();

    /**
     * Set id
     * @param string $Id
     * @return \Bigeyedeers\CheckoutMessage\Api\Data\CheckoutMessageInterface
     */
    public function setId($checkoutmessageId);

    /**
     * Get status
     * @return string|null
     */
    public function getStatus();

    /**
     * Set status
     * @param string $status
     * @return \Bigeyedeers\CheckoutMessage\Api\Data\CheckoutMessageInterface
     */
    public function setStatus($status);

    /**
     * Get message
     * @return string|null
     */
    public function getMessage();

    /**
     * Set message
     * @param string $message
     * @return \Bigeyedeers\CheckoutMessage\Api\Data\CheckoutMessageInterface
     */
    public function setMessage($message);
}

