<?php

namespace Codilar\PushNotification\Controller\Adminhtml\Template;

use Codilar\PushNotification\Api\TemplateManagementInterface;
use Magento\Backend\App\Action;


class Save extends Action
{
    const ADMIN_RESOURCE = "Codilar_PushNotification::pushnotify_template";

    /**
     * @var TemplateManagementInterface
     */
    private $templateManagement;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param TemplateManagementInterface $templateManagement
     */
    public function __construct(
        Action\Context $context,
        TemplateManagementInterface $templateManagement
    ) {
        parent::__construct($context);
        $this->templateManagement = $templateManagement;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $request = $this->getRequest();
        $model = $this->templateManagement->load($request->getParam('template_id'));
        $model->setTitle($request->getParam('title'));
        $model->setLogo($request->getParam('logo')[0]['url']);
        $model = $this->templateManagement->save($model);
        return $this->resultRedirectFactory->create()->setPath('pushnotify/template/view');
    }
}
