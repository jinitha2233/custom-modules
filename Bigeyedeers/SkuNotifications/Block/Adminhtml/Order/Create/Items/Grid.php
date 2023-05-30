<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\SkuNotifications\Block\Adminhtml\Order\Create\Items;

use Magento\Catalog\Model\Product\Attribute\Source\Status as ProductStatus;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\CatalogInventory\Api\StockStateInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Quote\Model\Quote\Item;

/**
 * Adminhtml sales order create items grid block
 * @api
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @since 100.0.2
 */
class Grid extends \Magento\Sales\Block\Adminhtml\Order\Create\Items\Grid
{
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Model\Session\Quote $sessionQuote
     * @param \Magento\Sales\Model\AdminOrder\Create $orderCreate
     * @param PriceCurrencyInterface $priceCurrency
     * @param \Magento\Wishlist\Model\WishlistFactory $wishlistFactory
     * @param \Magento\GiftMessage\Model\Save $giftMessageSave
     * @param \Magento\Tax\Model\Config $taxConfig
     * @param \Magento\Tax\Helper\Data $taxData
     * @param \Magento\GiftMessage\Helper\Message $messageHelper
     * @param StockRegistryInterface $stockRegistry
     * @param StockStateInterface $stockState
     * @param \Magento\Framework\Session\SessionManagerInterface $sessionManager
     * @param array $data
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Model\Session\Quote $sessionQuote,
        \Magento\Sales\Model\AdminOrder\Create $orderCreate,
        PriceCurrencyInterface $priceCurrency,
        \Magento\Wishlist\Model\WishlistFactory $wishlistFactory,
        \Magento\GiftMessage\Model\Save $giftMessageSave,
        \Magento\Tax\Model\Config $taxConfig,
        \Magento\Tax\Helper\Data $taxData,
        \Magento\GiftMessage\Helper\Message $messageHelper,
        StockRegistryInterface $stockRegistry,
        StockStateInterface $stockState,
        \Magento\Framework\Session\SessionManagerInterface $sessionManager,
        array $data = []
    ) {
        $this->sessionManager = $sessionManager;
        parent::__construct($context, $sessionQuote, $orderCreate, $priceCurrency, $wishlistFactory, $giftMessageSave, $taxConfig, $taxData, $messageHelper, $stockRegistry, $stockState, $data);
    }

    /**
     * @return array
     */
    public function getSkuNotifications()
    {
        $arrayMessage = $this->sessionManager->getMySession();
        $this->sessionManager->unsMySession();
        return $arrayMessage;
    }
}
