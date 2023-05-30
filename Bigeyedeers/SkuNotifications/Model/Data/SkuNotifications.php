<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\SkuNotifications\Model\Data;

use Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsInterface;

class SkuNotifications extends \Magento\Framework\Api\AbstractExtensibleObject implements SkuNotificationsInterface
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
     * @return \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsInterface
     */
    public function setId($Id)
    {
        return $this->setData(self::ID, $Id);
    }

    /**
     * Get title
     * @return string|null
     */
    public function getTitle()
    {
        return $this->_get(self::TITLE);
    }

    /**
     * Set title
     * @param string $title
     * @return \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
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
     * @return \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Get content
     * @return string|null
     */
    public function getContent()
    {
        return $this->_get(self::CONTENT);
    }

    /**
     * Set content
     * @param string $content
     * @return \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsInterface
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * Get sku
     * @return string|null
     */
    public function getSku()
    {
        return $this->_get(self::SKU);
    }

    /**
     * Set sku
     * @param string $sku
     * @return \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsInterface
     */
    public function setSku($sku)
    {
        return $this->setData(self::SKU, $sku);
    }

    /**
     * Get everySku
     * @return string|null
     */
    public function getEverySku()
    {
        return $this->_get(self::EVERY_SKU);
    }

    /**
     * Set everySku
     * @param string $everySku
     * @return \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsInterface
     */
    public function setEverySku($everySku)
    {
        return $this->setData(self::EVERY_SKU, $everySku);
    }
}

