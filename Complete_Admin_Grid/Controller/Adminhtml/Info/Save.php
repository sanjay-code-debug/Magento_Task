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

use Codilar\Demo\Model\ResourceModel\BrandsInfo\Collection;

class Save extends Action
{
    protected $dataPersistor;
    private $dataProvider;
    private $brandsRepository;
    private $collection;

    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        BrandsRepositoryInterface $brandsRepository,
        DataProvider $dataProvider,
        Collection $collection
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->dataProvider = $dataProvider;
        parent::__construct($context);
        $this->brandsRepository = $brandsRepository;
        $this->collection=$collection;
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
        $image = $this->getRequest()->getParam('image');

        $dbImage = $this->collection->getColumnValues('image');

        
        $dbImageStr = implode("/",$dbImage);
//        var_dump($dbImageStr);
//        var_dump($dbImage);
        $tempDbImg = explode("/",$dbImageStr);
        $lastValue = end($tempDbImg);
        var_dump($lastValue);
//        var_dump($tempDbImg);

//        Image From Local
         $localImg = explode("/",$image[0]['name']);
          $localImgLast = end($localImg);
          var_dump($localImgLast);
//         var_dump($localImg);

//        var_dump($image[0]['name']);

//        die('----');

        if ($lastValue!=$localImgLast)
        {
            $imageFullPath = '';
            if (is_array($image)) {
                $image = $image[0];
//            $tmpFile = $image['tmp_name'] ?? null;
                $imageName = $image['name'] ?? null;
//            $imageUrl = $image['url'] ?? null;
                $newImgRelativePath = $this->dataProvider->moveFileFromTmp($imageName);
//            die($newImgRelativePath);
                $imageFullPath = $this->dataProvider->getBasePath() . '/' . $newImgRelativePath;
            }

            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $brand = $this->brandsRepository->load($id);

            $brand->setName($name);
            $brand->setDob($dob);
            $brand->setPhone($phone);
            $brand->setEmail($email);
            $brand->setAddress($address);
            $brand->setImage($imageFullPath);
            $this->brandsRepository->save($brand);
            $this->messageManager->addSuccessMessage('User  successfully save');
            $resultRedirect->setUrl($this->getUrl('brand/info/index'));
            return $resultRedirect;
        }
        else{

            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $brand = $this->brandsRepository->load($id);


            $brand->setName($name);
            $brand->setDob($dob);
            $brand->setPhone($phone);
            $brand->setEmail($email);
            $brand->setAddress($address);
            $this->brandsRepository->save($brand);
            $this->messageManager->addSuccessMessage('User  successfully save');
            $resultRedirect->setUrl($this->getUrl('brand/info/index'));
            return $resultRedirect;
        }


//        die('-----');

//        $imageFullPath = '';
//        if (is_array($image)) {
//            $image = $image[0];
////            $tmpFile = $image['tmp_name'] ?? null;
//            $imageName = $image['name'] ?? null;
////            $imageUrl = $image['url'] ?? null;
//            $newImgRelativePath = $this->dataProvider->moveFileFromTmp($imageName);
////            die($newImgRelativePath);
//            $imageFullPath = $this->dataProvider->getBasePath() . '/' . $newImgRelativePath;
//        }
//
//        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
//        $brand = $this->brandsRepository->load($id);
//
//
//        $brand->setName($name);
//        $brand->setDob($dob);
//        $brand->setPhone($phone);
//        $brand->setEmail($email);
//        $brand->setAddress($address);
//        $brand->setImage($imageFullPath);
//        $this->brandsRepository->save($brand);
//        $this->messageManager->addSuccessMessage('User  successfully save');
//        $resultRedirect->setUrl($this->getUrl('brand/info/index'));
//        return $resultRedirect;
    }
}
