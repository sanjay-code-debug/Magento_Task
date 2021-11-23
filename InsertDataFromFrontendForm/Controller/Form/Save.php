<?php

namespace Codilar\FormDataInsertToAdminGrid\Controller\Form;

use Codilar\FormDataInsertToAdminGrid\Model\Form;
use Codilar\FormDataInsertToAdminGrid\Model\ResourceModel\Form as FormResourceModel;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Save extends Action
{
    /**
     * @var
     */
    private $form;
    /**
     * @var
     */
    private $formResourceModel;

    public function __construct(
        Context $context,
        Form $form,
        FormResourceModel $formResourceModel
    ) {
        $this->form = $form;
        $this->formResourceModel = $formResourceModel;
        parent::__construct($context);
    }

    public function execute()
    {
        $params = $this->getRequest()->getParams();
        $form = $this->form->setData($params);
        try {
            $this->formResourceModel->save($form);
            $this->messageManager->addSuccessMessage(__("Successfully added the The Data "));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__("Something Problem When Saving Data to Database."));
        }
        $redirect = $this->resultRedirectFactory->create();
        $redirect->setPath('form');
        return $redirect;
    }
}
