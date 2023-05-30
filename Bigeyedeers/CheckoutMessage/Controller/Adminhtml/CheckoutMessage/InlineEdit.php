<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\CheckoutMessage\Controller\Adminhtml\CheckoutMessage;

class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * @var \Bigeyedeers\CheckoutMessage\Model\CheckoutMessageRepository
     */
    protected $modelCheckoutMessage;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Bigeyedeers\CheckoutMessage\Model\CheckoutMessageRepository $modelCheckoutMessage
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Bigeyedeers\CheckoutMessage\Model\CheckoutMessageRepository $modelCheckoutMessage
    ) {
        $this->modelCheckoutMessage = $modelCheckoutMessage;
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * Inline edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $modelid) {
                    /** @var \Bigeyedeers\CheckoutMessage\Model\CheckoutMessage $model */
                    $model = $this->modelCheckoutMessage->get($modelid);
                    try {
                        $model->setData(array_merge($model->getData(), $postItems[$modelid]));
                        $this->modelCheckoutMessage->save($model);
                    } catch (\Exception $e) {
                        $messages[] = "[Checkout Message ID: {$modelid}]  {$e->getMessage()}";
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}

