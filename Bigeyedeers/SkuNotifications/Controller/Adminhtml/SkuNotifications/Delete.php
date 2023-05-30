<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\SkuNotifications\Controller\Adminhtml\SkuNotifications;

class Delete extends \Bigeyedeers\SkuNotifications\Controller\Adminhtml\SkuNotifications
{
    /**
     * @var \Bigeyedeers\SkuNotifications\Model\SkuNotificationsRepository
     */
    protected $modelSkuNotifications;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Bigeyedeers\SkuNotifications\Model\SkuNotificationsRepository $modelSkuNotifications
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Bigeyedeers\SkuNotifications\Model\SkuNotificationsRepository $modelSkuNotifications
    ) {
        $this->modelSkuNotifications = $modelSkuNotifications;
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
                $model = $this->modelSkuNotifications->get($id);
                $this->modelSkuNotifications->delete($model);
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Sku Notifications.'));
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
        $this->messageManager->addErrorMessage(__('We can\'t find a Sku Notifications to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}

