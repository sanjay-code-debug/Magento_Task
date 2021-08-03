<?php

namespace Codilar\PushNotification\Controller\Adminhtml\Template;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;



class View extends Action
{
    const ADMIN_RESOURCE = "Codilar_PushNotification::pushnotify_template";

    /**
     * @var PageFactory
     */
    private $pageFactory;

    public function __construct(
        Action\Context $context,
        PageFactory $pageFactory
    ) {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
    }

    /**
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute()
    {
        $resultPage = $this->pageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('User Information'));
        return $resultPage;
    }
}
