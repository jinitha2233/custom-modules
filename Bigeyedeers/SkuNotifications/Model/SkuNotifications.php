<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\SkuNotifications\Model;

use Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsInterface;
use Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;

class SkuNotifications extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var SkuNotificationsInterfaceFactory
     */
    protected $skunotificationsDataFactory;

    /**
     * @var string
     */
    protected $_eventPrefix = 'bigeyedeers_skunotifications';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param SkuNotificationsInterfaceFactory $skunotificationsDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Bigeyedeers\SkuNotifications\Model\ResourceModel\SkuNotifications $resource
     * @param \Bigeyedeers\SkuNotifications\Model\ResourceModel\SkuNotifications\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        SkuNotificationsInterfaceFactory $skunotificationsDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Bigeyedeers\SkuNotifications\Model\ResourceModel\SkuNotifications $resource,
        \Bigeyedeers\SkuNotifications\Model\ResourceModel\SkuNotifications\Collection $resourceCollection,
        array $data = []
    ) {
        $this->skunotificationsDataFactory = $skunotificationsDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve skunotifications model with skunotifications data
     * @return SkuNotificationsInterface
     */
    public function getDataModel()
    {
        $skunotificationsData = $this->getData();

        $skunotificationsDataObject = $this->skunotificationsDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $skunotificationsDataObject,
            $skunotificationsData,
            SkuNotificationsInterface::class
        );

        return $skunotificationsDataObject;
    }
}

