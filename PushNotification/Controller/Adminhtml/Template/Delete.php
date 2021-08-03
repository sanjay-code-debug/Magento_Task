<?php

namespace Codilar\PushNotification\Controller\Adminhtml\Template;

use Codilar\PushNotification\Api\TemplateManagementInterface;
use Magento\Backend\App\Action;
use Magento\Framework\Message\ManagerInterface;


class Delete extends Action
{
    const ADMIN_RESOURCE = "Codilar_PushNotification::pushnotify_template";

    /**
     * @var TemplateManagementInterface
     */
    private $templateManagement;
    /**
     * @var ManagerInterface
     */
    private $manager;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param TemplateManagementInterface $templateManagement
     * @param ManagerInterface $manager
     */
    public function __construct(
        Action\Context $context,
        TemplateManagementInterface $templateManagement,
        ManagerInterface $manager
    ) {
        parent::__construct($context);
        $this->templateManagement = $templateManagement;
        $this->manager = $manager;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('template_id');
        if ($this->templateManagement->load($id)->getId()) {
            if ($this->templateManagement->deleteById($id)) {
                $this->manager->addSuccessMessage('Template with Id ' . $id . ' has been successfully deleted');
            } else {
                $this->manager->addErrorMessage('Something went wrong');
            }
        } else {
            $this->manager->addErrorMessage('Template does not exists');
        }
        return $this->resultRedirectFactory->create()->setPath('pushnotify/template/view');
    }
}
