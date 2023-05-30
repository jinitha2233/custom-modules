<?php
/**
 * Copyright © Bigeyedeers, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\LinkedAddons\Model\ProductLink\CollectionProvider;
class Addons implements \Magento\Catalog\Model\ProductLink\CollectionProviderInterface {
    public function getLinkedProducts($product) {
        return $product->getAddons();
    }
}
