<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\CheckoutMessage\Model;

use Bigeyedeers\CheckoutMessage\Api\Data\CheckoutMessageInterfaceFactory;
use Bigeyedeers\CheckoutMessage\Api\Data\CheckoutMessageSearchResultsInterfaceFactory;
use Bigeyedeers\CheckoutMessage\Api\CheckoutMessageRepositoryInterface;
use Bigeyedeers\CheckoutMessage\Model\ResourceModel\CheckoutMessage as ResourceCheckoutMessage;
use Bigeyedeers\CheckoutMessage\Model\ResourceModel\CheckoutMessage\CollectionFactory as CheckoutMessageCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

class CheckoutMessageRepository implements CheckoutMessageRepositoryInterface
{
    /**
     * @var CheckoutMessageSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var JoinProcessorInterface
     */
    protected $extensionAttributesJoinProcessor;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var CheckoutMessageFactory
     */
    protected $checkoutMessageFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var ExtensibleDataObjectConverter
     */
    protected $extensibleDataObjectConverter;

    /**
     * @var ResourceCheckoutMessage
     */
    protected $resource;

    /**
     * @var CheckoutMessageInterfaceFactory
     */
    protected $dataCheckoutMessageFactory;

    /**
     * @var CheckoutMessageCollectionFactory
     */
    protected $checkoutMessageCollectionFactory;


    /**
     * @param ResourceCheckoutMessage $resource
     * @param CheckoutMessageFactory $checkoutMessageFactory
     * @param CheckoutMessageInterfaceFactory $dataCheckoutMessageFactory
     * @param CheckoutMessageCollectionFactory $checkoutMessageCollectionFactory
     * @param CheckoutMessageSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceCheckoutMessage $resource,
        CheckoutMessageFactory $checkoutMessageFactory,
        CheckoutMessageInterfaceFactory $dataCheckoutMessageFactory,
        CheckoutMessageCollectionFactory $checkoutMessageCollectionFactory,
        CheckoutMessageSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->checkoutMessageFactory = $checkoutMessageFactory;
        $this->checkoutMessageCollectionFactory = $checkoutMessageCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataCheckoutMessageFactory = $dataCheckoutMessageFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Bigeyedeers\CheckoutMessage\Api\Data\CheckoutMessageInterface $checkoutMessage
    ) {
        /* if (empty($checkoutMessage->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $checkoutMessage->setStoreId($storeId);
        } */

        $checkoutMessageData = $this->extensibleDataObjectConverter->toNestedArray(
            $checkoutMessage,
            [],
            \Bigeyedeers\CheckoutMessage\Api\Data\CheckoutMessageInterface::class
        );

        $checkoutMessageModel = $this->checkoutMessageFactory->create()->setData($checkoutMessageData);

        try {
            $this->resource->save($checkoutMessageModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the Checkout Message: %1',
                $exception->getMessage()
            ));
        }
        return $checkoutMessageModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($checkoutMessageId)
    {
        $checkoutMessage = $this->checkoutMessageFactory->create();

        $this->resource->load($checkoutMessage, $checkoutMessageId);
        if ($checkoutMessageId && !$checkoutMessage->getId()) {
            throw new NoSuchEntityException(__('Checkout Message with id "%1" does not exist.', $checkoutMessageId));
        }

        return $checkoutMessage->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->checkoutMessageCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Bigeyedeers\CheckoutMessage\Api\Data\CheckoutMessageInterface::class
        );

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Bigeyedeers\CheckoutMessage\Api\Data\CheckoutMessageInterface $checkoutMessage
    ) {
        try {
            $checkoutMessageModel = $this->checkoutMessageFactory->create();
            $this->resource->load($checkoutMessageModel, $checkoutMessage->getId());
            $this->resource->delete($checkoutMessageModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the CheckoutMessage: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($checkoutMessageId)
    {
        return $this->delete($this->get($checkoutMessageId));
    }
}

