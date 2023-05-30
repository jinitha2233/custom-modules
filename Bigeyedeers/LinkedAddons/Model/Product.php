<?php
/**
 * Copyright © Bigeyedeers, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\LinkedAddons\Model;

class Product extends \Magento\Catalog\Model\Product
{
    const LINK_TYPE = 'addons';
    const LINK_TYPE_ADDONS = 6;

    /**
     * Retrieve array of customlink products
     *
     * @return array
     */
    public function getAddons()
    {
        if (!$this->hasAddonsProducts()) {
            $products = [];
            $collection = $this->getAddonsCollection();
            foreach ($collection as $product) {
                $products[] = $product;
            }
            $this->setAddons($products);
            $this->setData('addons', $products);
        }
        return $this->getData('addons');
    }

    /**
     * Retrieve customlink products identifiers
     *
     * @return array
     */
    public function getAddonsIds()
    {
        if (!$this->hasAddonsIds()) {
            $ids = [];
            foreach ($this->getAddons() as $product) {
                $ids[] = $product->getId();
            }
            $this->setAddonsIds($ids);
        }
        return [$this->getData('addons_ids')];
    }

    /**
     * Retrieve collection customlink product
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Link\Product\Collection
     */
    public function getAddonsCollection()
    {
        $collection = $this->getLinkInstance()->setLinkTypeId(
            static::LINK_TYPE_ADDONS
        )->getProductCollection()->setIsStrongMode();
        $collection->setProduct($this);

        return $collection;
    }
}
