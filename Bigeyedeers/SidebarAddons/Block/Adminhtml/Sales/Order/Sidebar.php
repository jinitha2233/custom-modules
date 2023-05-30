<?php
/**
 * Copyright © Bigeyedeers, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\SidebarAddons\Block\Adminhtml\Sales\Order;

use Magento\Framework\Pricing\PriceCurrencyInterface;

class Sidebar extends \Magento\Sales\Block\Adminhtml\Order\Create\Sidebar\AbstractSidebar
{
    private string $linkKey;
    private string $headerText;
    private \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory;
    private $callHandlingSku;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Model\Session\Quote $sessionQuote,
        \Magento\Sales\Model\AdminOrder\Create $orderCreate,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        PriceCurrencyInterface $priceCurrency,
        \Magento\Sales\Model\Config $salesConfig,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        string $linkKey = '',
        string $headerText = '',
        array $data = []
    ) {
        $this->linkKey = $linkKey;
        $this->headerText = $headerText;
        $this->productCollectionFactory = $productCollectionFactory;
        parent::__construct($context, $sessionQuote, $orderCreate, $priceCurrency, $salesConfig, $data);
    }

    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        if($this->linkKey == "addons") {
            $this->setId('sales_order_create_sidebar_'.$this->linkKey);
        }
        else {
            $this->setId('sales_order_create_sidebar_addons_' . $this->linkKey);
        }
        $this->setDataId($this->linkKey);
    }

    /**
     * Get header text
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        return __($this->headerText);
    }

    public function getItemCollection()
    {
        $productCollection = $this->getData('item_collection');

        if ($productCollection === null) {
            $allLinkedProductIds = [];
            if ($this->_sessionQuote->getQuote()->getData('calllog_sku')) {
                $allLinkedProductIds = array_merge(
                    $allLinkedProductIds,
                    $this->getCallHandlingSkuIds($this->_sessionQuote->getQuote()->getData('calllog_sku')));
            }
            $quoteItems = $this->_sessionQuote->getQuote()->getAllVisibleItems();
            if ($quoteItems) {
                if($this->linkKey == "addons") {
                    foreach ($quoteItems as $item) {
                        $allLinkedProductIds = array_merge($allLinkedProductIds,$this->getLinkedAddons($item));
                    }
                }
                else {
                    foreach ($quoteItems as $item) {
                        $allLinkedProductIds = array_merge($allLinkedProductIds,$this->getLinkedProducts($item));
                    }
                }
            }
            if (count($allLinkedProductIds) > 0) {
                $productCollection = $this->getLinkedCollection($allLinkedProductIds);
            }
        }

        $this->setData('item_collection', $productCollection);
        return $productCollection;
    }

    private function getLinkedProducts($item)
    {
        $linkedProductIds = [];
        $product = $item->getProduct();
        $product->getProductLinks();
        if ($product->getData($this->linkKey)) {
            foreach ($product->getData($this->linkKey) as $linkedProduct) {
                $linkedProductIds[] = $linkedProduct->getId();
            }
        }
        return $linkedProductIds;
    }

    private function getLinkedAddons($item)
    {
        $linkedProductIds = [];
        $product = $item->getProduct();

        if ($product->getAddons()) {
            foreach ($product->getAddons() as $linkedProduct) {
                $linkedProductIds[] = $linkedProduct->getId();
            }
        }
        return $linkedProductIds;
    }

    private function getLinkedCollection($productIds)
    {
        return $this->productCollectionFactory->create()
            ->setStoreId(
                $this->getQuote()->getStoreId()
            )->addAttributeToSelect(
                'name'
            )->addAttributeToSelect(
                'price'
            )->addAttributeToSelect(
                'small_image'
            )->addIdFilter(
                $productIds
            )->load();
    }

    /**
     * Retrieve availability removing items in block
     *
     * @return false
     */
    public function canRemoveItems()
    {
        return false;
    }

    /**
     * Get product Id
     *
     * @param \Magento\Catalog\Model\Product $item
     * @return int
     */
    public function getIdentifierId($item)
    {
        return $item->getId();
    }

    /**
     * Retrieve product identifier of block item
     *
     * @param \Magento\Framework\DataObject $item
     * @return int
     */
    public function getProductId($item)
    {
        return $item->getId();
    }

    private function getCallHandlingSkuIds($sku)
    {
        $linkedProductIds = [];
        if (is_string($sku)) {
            $products = $this->productCollectionFactory->create()
                    ->addAttributeToFilter('sku', ['eq' => $sku])
                    ->load()->getItems();
            foreach ($products as $product) {
                $product->getProductLinks();
                if ($product->getData($this->linkKey)) {
                    foreach ($product->getData($this->linkKey) as $linkedProduct) {
                        $linkedProductIds[] = $linkedProduct->getId();
                    }
                }
            }
        }
        return $linkedProductIds;
    }
}
