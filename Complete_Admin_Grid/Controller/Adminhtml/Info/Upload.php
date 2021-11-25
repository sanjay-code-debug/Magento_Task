<?php


namespace Codilar\Demo\Controller\Adminhtml\Info;

use Codilar\Demo\Model\DataProvider;
use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;

class Upload extends Action implements HttpPostActionInterface
{
    /**
     * @var DataProvider
     */
    private $imageUploader;

    /**
     * Upload constructor.
     * @param Action\Context $context
     * @param DataProvider $imageUploader
     */
    public function __construct(Action\Context $context, DataProvider $imageUploader)
    {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
    }
    /**
     * @inheritDoc
     */
    public function execute()
    {
        $imageId = $this->getRequest()->getParam('param_name', 'image');

        try {
            $result = $this->imageUploader->saveFileToTmpDir($imageId);
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }

        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        return $resultJson->setData($result);
    }
}
