<?php

namespace Codilar\Demo\Controller\Adminhtml\Info;

use Codilar\Demo\Api\BrandsRepositoryInterface;
use Codilar\Demo\Model\DataProvider;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends Action
{
    protected $dataPersistor;
    private $dataProvider;
    private $brandsRepository;

    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        BrandsRepositoryInterface $brandsRepository,
        DataProvider $dataProvider
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->dataProvider = $dataProvider;
        parent::__construct($context);
        $this->brandsRepository = $brandsRepository;
    }
    /**
     * @return ResponseInterface|ResultInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $name = $this->getRequest()->getParam('name');
        $dob =  $this->getRequest()->getParam('dob');
        $phone = $this->getRequest()->getParam('phone');
        $email = $this->getRequest()->getParam('email');
        $address = $this->getRequest()->getParam('address');
        $dropdown = $this->getRequest()->getParam('dropdown');
        $image = $this->getRequest()->getParam('image');
        $imageFullPath = '';
        if (is_array($image)) {
            $image = $image[0];
            $tmpFile = $image['tmp_name'] ?? null;
            $imageName = $image['name'] ?? null;
            $imageUrl = $image['url'] ?? null;
            $newImgRelativePath = $this->dataProvider->moveFileFromTmp($imageName);
            $imageFullPath = $this->dataProvider->getBasePath() . '/' . $newImgRelativePath;
        }

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $brand = $this->brandsRepository->load($id);
        $brand->setName($name);
        $brand->setDob($dob);
        $brand->setPhone($phone);
        $brand->setEmail($email);
        $brand->setAddress($address);
        $brand->setDropdown($dropdown);
        $brand->setImage($imageFullPath);
        $this->brandsRepository->save($brand);
        $this->messageManager->addSuccessMessage('User  successfully save');
        $resultRedirect->setUrl($this->getUrl('brand/info/index'));
        return $resultRedirect;
    }
}
