<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\CheckoutMessage\Controller\Adminhtml\CheckoutMessage;

class Edit extends \Bigeyedeers\CheckoutMessage\Controller\Adminhtml\CheckoutMessage
{
    /**
     * @var \Bigeyedeers\CheckoutMessage\Model\CheckoutMessageRepository
     */
    protected $modelCheckoutMessage;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Bigeyedeers\CheckoutMessage\Model\CheckoutMessageRepository $modelCheckoutMessage
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Bigeyedeers\CheckoutMessage\Model\CheckoutMessageRepository $modelCheckoutMessage
    ) {
        $this->modelCheckoutMessage = $modelCheckoutMessage;
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
            $model = $this->modelCheckoutMessage->get($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Checkout Message no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->_coreRegistry->register('bigeyedeers_checkoutmessage', $model);

        // 3. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Checkout Message') : __('New Checkout Message'),
            $id ? __('Edit Checkout Message') : __('New Checkout Message')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Checkout Message'));
        $resultPage->getConfig()->getTitle()->prepend($id && $model->getId() ? __('Edit Checkout Message %1', $model->getId()) : __('New Checkout Message'));
        return $resultPage;
    }
}

