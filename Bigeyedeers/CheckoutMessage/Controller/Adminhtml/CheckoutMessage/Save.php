<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\CheckoutMessage\Controller\Adminhtml\CheckoutMessage;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Bigeyedeers\CheckoutMessage\Model\CheckoutMessageRepository
     */
    protected $modelCheckoutMessage;

    /**
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param \Bigeyedeers\CheckoutMessage\Model\CheckoutMessageRepository $modelCheckoutMessage
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Bigeyedeers\CheckoutMessage\Model\CheckoutMessageRepository $modelCheckoutMessage
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->modelCheckoutMessage = $modelCheckoutMessage;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $id = $this->getRequest()->getParam('id');
            $model = $this->modelCheckoutMessage->get($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Checkout Message no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setMessage($data['message']);
            $model->setStatus($data['status']);

            try {
                $this->modelCheckoutMessage->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the Checkout Message.'));
                $this->dataPersistor->clear('bigeyedeers_checkoutmessage');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Checkout Message.'));
            }

            $this->dataPersistor->set('bigeyedeers_checkoutmessage', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}

