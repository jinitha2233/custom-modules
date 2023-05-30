<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\SkuNotifications\Controller\Adminhtml\SkuNotifications;

class Edit extends \Bigeyedeers\SkuNotifications\Controller\Adminhtml\SkuNotifications
{
    /**
     * @var \Bigeyedeers\SkuNotifications\Model\SkuNotificationsRepository
     */
    protected $modelSkuNotifications;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Bigeyedeers\SkuNotifications\Model\SkuNotificationsRepository $modelSkuNotifications
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Bigeyedeers\SkuNotifications\Model\SkuNotificationsRepository $modelSkuNotifications
    ) {
        $this->modelSkuNotifications = $modelSkuNotifications;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = null;

        // 2. Initial checking
        if ($id) {
            $model = $this->modelSkuNotifications->get($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Sku Notifications no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->_coreRegistry->register('bigeyedeers_skunotifications', $model);

        // 3. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Sku Notifications') : __('New Sku Notifications'),
            $id ? __('Edit Sku Notifications') : __('New Sku Notifications')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Sku Notifications'));
        $resultPage->getConfig()->getTitle()->prepend($id && $model->getId() ? __('Edit Sku Notifications %1', $model->getId()) : __('New Sku Notifications'));
        return $resultPage;
    }
}

