<?php
/**
 * Copyright © Bigeyedeers, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\CheckoutMessage\Block\Adminhtml\Order\Create;

/**
 * Adminhtml checkout Message
 * @api
 * @author bigeyedeers
 * @since 100.0.2
 */
class CheckoutMessage extends \Magento\Backend\Block\Template
{
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Bigeyedeers\CheckoutMessage\Model\ResourceModel\CheckoutMessage\CollectionFactory $checkoutMessage
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Bigeyedeers\CheckoutMessage\Model\ResourceModel\CheckoutMessage\CollectionFactory $checkoutMessage,
        array $data = []
    ) {
        $this->context = $context;
        $this->checkoutMessage = $checkoutMessage;
        parent::__construct($context, $data);
    }

    public function getCheckoutMessages()
    {
        $checkoutMessageCollection = $this->checkoutMessage->create()->addFieldToFilter('status', array('eq' => 1));
        $checkoutMessage = $checkoutMessageCollection->getData();
        return $checkoutMessage;
    }
}
