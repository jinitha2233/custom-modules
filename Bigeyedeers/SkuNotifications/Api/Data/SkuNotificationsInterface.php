<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\SkuNotifications\Api\Data;

interface SkuNotificationsInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const ID = 'id';
    const CONTENT = 'content';
    const SKU = 'sku';
    const TITLE = 'title';
    const STATUS = 'status';
    const EVERY_SKU = 'every_sku';

    /**
     * Get id
     * @return string|null
     */
    public function getId();

    /**
     * Set id
     * @param string $Id
     * @return \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsInterface
     */
    public function setId($skunotificationsId);

    /**
     * Get title
     * @return string|null
     */
    public function getTitle();

    /**
     * Set title
     * @param string $title
     * @return \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsInterface
     */
    public function setTitle($title);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsExtensionInterface $extensionAttributes
    );

    /**
     * Get status
     * @return string|null
     */
    public function getStatus();

    /**
     * Set status
     * @param string $status
     * @return \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsInterface
     */
    public function setStatus($status);

    /**
     * Get content
     * @return string|null
     */
    public function getContent();

    /**
     * Set content
     * @param string $content
     * @return \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsInterface
     */
    public function setContent($content);

    /**
     * Get sku
     * @return string|null
     */
    public function getSku();

    /**
     * Set sku
     * @param string $sku
     * @return \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsInterface
     */
    public function setSku($sku);

    /**
     * Get everySku
     * @return string|null
     */
    public function getEverySku();

    /**
     * Set everySku
     * @param string $sku
     * @return \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsInterface
     */
    public function setEverySku($everySku);
}

