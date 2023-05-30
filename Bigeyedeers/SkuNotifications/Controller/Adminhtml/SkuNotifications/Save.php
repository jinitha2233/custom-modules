<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\SkuNotifications\Controller\Adminhtml\SkuNotifications;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Bigeyedeers\SkuNotifications\Model\SkuNotificationsRepository
     */
    protected $modelSkuNotifications;

    /**
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param \Bigeyedeers\SkuNotifications\Model\SkuNotificationsRepository $modelSkuNotifications
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Bigeyedeers\SkuNotifications\Model\SkuNotificationsRepository $modelSkuNotifications
    ) {
        $this->modelSkuNotifications = $modelSkuNotifications;
        $this->dataPersistor = $dataPersistor;
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

            $model = $this->modelSkuNotifications->get($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Sku Notifications no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setTitle($data['title']);
            $model->setStatus($data['status']);
            $model->setContent($data['content']);
            $model->setSku($data['sku']);
            $model->setEverySku(isset($data['every_sku'])?$data['every_sku']:0);

            try {
                $this->modelSkuNotifications->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the Sku Notifications.'));
                $this->dataPersistor->clear('bigeyedeers_skunotifications');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Sku Notifications.'));
            }

            $this->dataPersistor->set('bigeyedeers_skunotifications', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}

