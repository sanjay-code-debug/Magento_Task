<?php

namespace Codilar\User\Controller\Adminhtml\Info;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Codilar\User\Model\ResourceModel\User\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\ResponseInterface;
/**
 * Class MassDisable
 */
class MassDelete extends \Magento\Backend\App\Action {
    /**
     * @var Filter
     */
    protected $_filter;
    /**
     * @var CollectionFactory
     */
    protected $_collectionFactory;
    /**
     * MassDelete constructor.
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param Context $context
     */
    public function __construct(
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Codilar\User\Model\ResourceModel\User\CollectionFactory $collectionFactory,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->_filter            = $filter;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|Redirect|ResultInterface
     * @throws LocalizedException
     */
    public function execute() {
        try{
            $logCollection = $this->_filter->getCollection($this->_collectionFactory->create());
            //echo "<pre>";
            //print_r($logCollection->getData());
            //exit;
            foreach ($logCollection as $item) {
                $item->delete();
            }
            $this->messageManager->addSuccessMessage(__(' Deleted Successfully.'));
        }catch(Exception $e){
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index');
    }
}
