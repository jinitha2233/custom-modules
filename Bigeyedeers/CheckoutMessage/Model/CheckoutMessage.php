<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\CheckoutMessage\Model;

use Bigeyedeers\CheckoutMessage\Api\Data\CheckoutMessageInterface;
use Bigeyedeers\CheckoutMessage\Api\Data\CheckoutMessageInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;

class CheckoutMessage extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var CheckoutMessageInterfaceFactory
     */
    protected $checkoutmessageDataFactory;

    /**
     * @var string
     */
    protected $_eventPrefix = 'bigeyedeers_checkoutmessage';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param CheckoutMessageInterfaceFactory $checkoutmessageDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Bigeyedeers\CheckoutMessage\Model\ResourceModel\CheckoutMessage $resource
     * @param \Bigeyedeers\CheckoutMessage\Model\ResourceModel\CheckoutMessage\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        CheckoutMessageInterfaceFactory $checkoutmessageDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Bigeyedeers\CheckoutMessage\Model\ResourceModel\CheckoutMessage $resource,
        \Bigeyedeers\CheckoutMessage\Model\ResourceModel\CheckoutMessage\Collection $resourceCollection,
        array $data = []
    ) {
        $this->checkoutmessageDataFactory = $checkoutmessageDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve checkoutmessage model with checkoutmessage data
     * @return CheckoutMessageInterface
     */
    public function getDataModel()
    {
        $checkoutmessageData = $this->getData();

        $checkoutmessageDataObject = $this->checkoutmessageDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $checkoutmessageDataObject,
            $checkoutmessageData,
            CheckoutMessageInterface::class
        );

        return $checkoutmessageDataObject;
    }
}
