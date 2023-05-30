<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\CheckoutMessage\Controller\Adminhtml\CheckoutMessage;

class Delete extends \Bigeyedeers\CheckoutMessage\Controller\Adminhtml\CheckoutMessage
{
    /**
     * @var \Bigeyedeers\CheckoutMessage\Model\CheckoutMessageRepository
     */
    protected $modelCheckoutMessage;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Bigeyedeers\CheckoutMessage\Model\CheckoutMessageRepository $modelCheckoutMessage
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Bigeyedeers\CheckoutMessage\Model\CheckoutMessageRepository $modelCheckoutMessage
    ) {
        $this->modelCheckoutMessage = $modelCheckoutMessage;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->modelCheckoutMessage->get($id);
                $this->modelCheckoutMessage->delete($model);
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Checkout Message.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Checkout Message to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}

