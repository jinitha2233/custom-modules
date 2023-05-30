<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\SkuNotifications\Model;

use Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsInterfaceFactory;
use Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsSearchResultsInterfaceFactory;
use Bigeyedeers\SkuNotifications\Api\SkuNotificationsRepositoryInterface;
use Bigeyedeers\SkuNotifications\Model\ResourceModel\SkuNotifications as ResourceSkuNotifications;
use Bigeyedeers\SkuNotifications\Model\ResourceModel\SkuNotifications\CollectionFactory as SkuNotificationsCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

class SkuNotificationsRepository implements SkuNotificationsRepositoryInterface
{
    /**
     * @var SkuNotificationsSearchResultsInterfaceFactory
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
     * @var SkuNotificationsFactory
     */
    protected $skuNotificationsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var ExtensibleDataObjectConverter
     */
    protected $extensibleDataObjectConverter;

    /**
     * @var ResourceSkuNotifications
     */
    protected $resource;

    /**
     * @var SkuNotificationsInterfaceFactory
     */
    protected $dataSkuNotificationsFactory;

    /**
     * @var SkuNotificationsCollectionFactory
     */
    protected $skuNotificationsCollectionFactory;


    /**
     * @param ResourceSkuNotifications $resource
     * @param SkuNotificationsFactory $skuNotificationsFactory
     * @param SkuNotificationsInterfaceFactory $dataSkuNotificationsFactory
     * @param SkuNotificationsCollectionFactory $skuNotificationsCollectionFactory
     * @param SkuNotificationsSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceSkuNotifications $resource,
        SkuNotificationsFactory $skuNotificationsFactory,
        SkuNotificationsInterfaceFactory $dataSkuNotificationsFactory,
        SkuNotificationsCollectionFactory $skuNotificationsCollectionFactory,
        SkuNotificationsSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->skuNotificationsFactory = $skuNotificationsFactory;
        $this->skuNotificationsCollectionFactory = $skuNotificationsCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataSkuNotificationsFactory = $dataSkuNotificationsFactory;
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
        \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsInterface $skuNotifications
    ) {
        /* if (empty($skuNotifications->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $skuNotifications->setStoreId($storeId);
        } */

        $skuNotificationsData = $this->extensibleDataObjectConverter->toNestedArray(
            $skuNotifications,
            [],
            \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsInterface::class
        );

        $skuNotificationsModel = $this->skuNotificationsFactory->create()->setData($skuNotificationsData);

        try {
            $this->resource->save($skuNotificationsModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the Sku Notification: %1',
                $exception->getMessage()
            ));
        }
        return $skuNotificationsModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($skuNotificationsId)
    {
        $skuNotifications = $this->skuNotificationsFactory->create();
        $this->resource->load($skuNotifications, $skuNotificationsId);
        if ($skuNotificationsId && !$skuNotifications->getId()) {
            throw new NoSuchEntityException(__('Sku Notification with id "%1" does not exist.', $skuNotificationsId));
        }
        return $skuNotifications->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->skuNotificationsCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsInterface::class
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
        \Bigeyedeers\SkuNotifications\Api\Data\SkuNotificationsInterface $skuNotifications
    ) {
        try {
            $skuNotificationsModel = $this->skuNotificationsFactory->create();
            $this->resource->load($skuNotificationsModel, $skuNotifications->getId());
            $this->resource->delete($skuNotificationsModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the SkuNotifications: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($skuNotificationsId)
    {
        return $this->delete($this->get($skuNotificationsId));
    }
}

