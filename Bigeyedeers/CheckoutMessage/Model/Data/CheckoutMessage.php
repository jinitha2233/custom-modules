<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\CheckoutMessage\Model\Data;

use Bigeyedeers\CheckoutMessage\Api\Data\CheckoutMessageInterface;

class CheckoutMessage extends \Magento\Framework\Api\AbstractExtensibleObject implements CheckoutMessageInterface
{

    /**
     * Get id
     * @return string|null
     */
    public function getId()
    {
        return $this->_get(self::ID);
    }

    /**
     * Set id
     * @param string $Id
     * @return \Bigeyedeers\CheckoutMessage\Api\Data\CheckoutMessageInterface
     */
    public function setId($Id)
    {
        return $this->setData(self::ID, $Id);
    }

    /**
     * Get status
     * @return string|null
     */
    public function getStatus()
    {
        return $this->_get(self::STATUS);
    }

    /**
     * Set status
     * @param string $status
     * @return \Bigeyedeers\CheckoutMessage\Api\Data\CheckoutMessageInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Get message
     * @return string|null
     */
    public function getMessage()
    {
        return $this->_get(self::MESSAGE);
    }

    /**
     * Set message
     * @param string $message
     * @return \Bigeyedeers\CheckoutMessage\Api\Data\CheckoutMessageInterface
     */
    public function setMessage($message)
    {
        return $this->setData(self::MESSAGE, $message);
    }
}

