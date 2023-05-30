<?php
/**
 * Copyright © Bigeyedeers, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\LinkedAddons\Plugin;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\Related as RelatedParent;
use Magento\Ui\Component\Form\Fieldset;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Framework\UrlInterface;
use Magento\Catalog\Api\ProductLinkRepositoryInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Eav\Api\AttributeSetRepositoryInterface;
use Magento\Framework\ObjectManagerInterface;

class Related extends RelatedParent {
    const GROUP_RELATED = 'related';
    const DATA_SCOPE_ADDONS = 'addons';

    /**
     * Object Manager
     *
     * @var ObjectManagerInterface
     */
    private $objectManager;

    private $priceModifier;
    protected $product;

    /**
     * @param LocatorInterface $locator
     * @param UrlInterface $urlBuilder
     * @param ProductLinkRepositoryInterface $productLinkRepository
     * @param ProductRepositoryInterface $productRepository
     * @param ImageHelper $imageHelper
     * @param Status $status
     * @param AttributeSetRepositoryInterface $attributeSetRepository
     * @param string $scopeName
     * @param string $scopePrefix
     */
    public function __construct(
        LocatorInterface $locator,
        UrlInterface $urlBuilder,
        ProductLinkRepositoryInterface $productLinkRepository,
        ProductRepositoryInterface $productRepository,
        ImageHelper $imageHelper,
        Status $status,
        AttributeSetRepositoryInterface $attributeSetRepository,
        ObjectManagerInterface $objectManager,
        \Bigeyedeers\LinkedAddons\Model\ProductFactory $catalogModel,
        $scopeName = '',
        $scopePrefix = ''
    ) {
        $this->objectManager = $objectManager;
        $this->catalogModel = $catalogModel;
        parent::__construct($locator, $urlBuilder, $productLinkRepository, $productRepository, $imageHelper, $status, $attributeSetRepository, $scopeName, $scopePrefix);
    }

    public function afterModifyMeta($modify, $result) {
        if (isset($result[static::GROUP_RELATED]['children'])) {
            $result[static::GROUP_RELATED]['children'][$modify->scopePrefix . static::DATA_SCOPE_ADDONS] = $this->getAddonsFieldset($modify);
        }
        if(isset($result[static::GROUP_RELATED]['arguments']['data']['config']['label'])){
            $result[static::GROUP_RELATED]['arguments']['data']['config']['label'] = 'Related Products, Up-Sells, Cross-Sells, and Addons';
        }
        return $result;
    }
    /**
     * Get price modifier
     *
     * @return \Magento\Catalog\Ui\Component\Listing\Columns\Price
     * @deprecated 101.0.0
     */
    private function getPriceModifier($modify) {
        if (!$this->priceModifier) {
            $this->priceModifier = $this->objectManager->get(
                    \Magento\Catalog\Ui\Component\Listing\Columns\Price::class
            );
        }
        return $this->priceModifier;
    }
    /**
     * Prepares config for the Related products fieldset
     *
     * @return array
     * @since 101.0.0
     */
    protected function getAddonsFieldset($modify) {
        $content = __(
                'Product Add-Ons allow your customers to personalize product.'
        );
        return [
            'children' => [
                'button_set' => $modify->getButtonSet(
                        $content, __('Add Addon Products'), $modify->scopePrefix . static::DATA_SCOPE_ADDONS
                ),
                'modal' => $this->getGenericModal(
                        __('Add Addon Products'), $modify->scopePrefix . static::DATA_SCOPE_ADDONS
                ),
                static::DATA_SCOPE_ADDONS => $this->getGrid($modify->scopePrefix . static::DATA_SCOPE_ADDONS),
            ],
            'arguments' => [
                'data' => [
                    'config' => [
                        'additionalClasses' => 'admin__fieldset-section',
                        'label' => __('Addon Products'),
                        'collapsible' => false,
                        'componentType' => Fieldset::NAME,
                        'dataScope' => '',
                        'sortOrder' => 40,
                    ],
                ],
            ]
        ];
    }
    public function afterModifyData($modify , $data)
    {
        $product = $modify->locator->getProduct();
        $productId = $product->getId();

        if (!$productId) {
            return $data;
        }
        $priceModifier = $this->getPriceModifier($modify);
        /**
         * Set field name for modifier
         */
        $priceModifier->setData('name', 'price');
        $dataScopes = $this->getDataScopes();
        $dataScopes[] = static::DATA_SCOPE_ADDONS;
        foreach ($dataScopes as $dataScope) {
            if($dataScope == static::DATA_SCOPE_ADDONS){
            $data[$productId]['links'][$dataScope] = [];
            foreach ($modify->productLinkRepository->getList($product) as $linkItem) {
                if ($linkItem->getLinkType() !== $dataScope) {
                    continue;
                }

                /** @var \Magento\Catalog\Model\Product $linkedProduct */
                $linkedProduct = $modify->productRepository->get(
                    $linkItem->getLinkedProductSku(),
                    false,
                    $modify->locator->getStore()->getId()
                );
                $data[$productId]['links'][$dataScope][] = $this->fillData($linkedProduct, $linkItem);
            }
            if (!empty($data[$productId]['links'][$dataScope])) {
                $dataMap = $priceModifier->prepareDataSource([
                    'data' => [
                        'items' => $data[$productId]['links'][$dataScope]
                    ]
                ]);
                $data[$productId]['links'][$dataScope] = $dataMap['data']['items'];
            }
        }
        }

        return $data;
    }

    /**
     * Before plugin to update model class
     *
     * @param \Bigeyedeers\LinkedAddons\Model\ProductLink\CollectionProvider\Addons $subject
     * @param Object $product
     * @return array
     */
    public function beforeGetLinkedProducts(\Bigeyedeers\LinkedAddons\Model\ProductLink\CollectionProvider\Addons $subject, $product
    ) {
        $currentProduct = $this->catalogModel->create()->load($product->getId());
        return [$currentProduct];
    }

}
