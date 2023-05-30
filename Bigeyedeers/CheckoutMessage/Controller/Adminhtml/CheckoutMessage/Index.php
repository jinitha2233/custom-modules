<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Bigeyedeers\CheckoutMessage\Controller\Adminhtml\CheckoutMessage;

class Index extends \Magento\Framework\App\Action\Action
{
     /**
     * @var resultPageFactory
     */
     protected $resultPageFactory;

     /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $pageFactory
     */
     public function __construct(
          \Magento\Framework\App\Action\Context $context,
          \Magento\Framework\View\Result\PageFactory $resultPageFactory
          )
     {
          $this->resultPageFactory = $resultPageFactory;
          return parent::__construct($context);
     }

     /**
     * Index action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
     public function execute()
     {
          $resultPage = $this->resultPageFactory->create();
          $resultPage->getConfig()->getTitle()->prepend((__('Checkout Message')));

          return $resultPage;
     }
}
