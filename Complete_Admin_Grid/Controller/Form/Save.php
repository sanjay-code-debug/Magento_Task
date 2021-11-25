<?php

namespace Codilar\Demo\Controller\Form;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 *
 */
use Codilar\Demo\Model\BrandsInfo;
use Codilar\Demo\Model\ResourceModel\BrandsInfo as BrandResourceModel;
use Codilar\Demo\Model\ResourceModel\BrandsInfo\Collection;

class  Save extends Action {

    /**
     * @var BrandsInfo
     */
    private  $brand;

    /**
     * @var BrandResourceModel
     */
    private  $brandResource;

    /**
     * @var Collection
     */
    private  $collection;

    /**
     * @var UploaderFactory
     */
    protected $uploaderFactory;
    /**
     * @var AdapterFactory
     */
    protected $adapterFactory;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    public function __construct(
        Context $context,
        BrandsInfo $brand,
        BrandResourceModel $brandResource,
        UploaderFactory $uploaderFactory,
        AdapterFactory $adapterFactory,
        Filesystem $filesystem,
        Collection $collection
    )
    {
        parent::__construct($context);
        $this->brand = $brand;
        $this->brandResource = $brandResource;
        $this->uploaderFactory = $uploaderFactory;
        $this->adapterFactory = $adapterFactory;
        $this->filesystem = $filesystem;
        $this->collection=$collection;
    }

    public function execute()
    {
        /** Get The Data   */
        $data = $this->getRequest()->getParams();
        $file = $this->getRequest()->getFiles();
        $email = $this->getRequest()->getParam('email');
        $phone = $this->getRequest()->getParam('phone');

        $dbEmail = $this->collection->getColumnValues('email');
        $dbPhone = $this->collection->getColumnValues('phone');


        /** Set The Data into Model */
        $brandModel = $this->brand;

        foreach ($dbEmail as $eml){
              if ($eml!=$email){
                  if (isset($file['image']) && !empty($file['image']['name'])){

                      try {
                          $uploaderFactory = $this->uploaderFactory->create(['fileId' => 'image']);
                          $uploaderFactory->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                          $uploaderFactory->setAllowRenameFiles(true);
                          $uploaderFactory->setFilesDispersion(true);
                          $mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
                          $destinationPath = $mediaDirectory->getAbsolutePath('mediaimage');
                          $result = $uploaderFactory->save($destinationPath);

                          if (!$result) {
                              throw new LocalizedException(
                                  __('File cannot be saved to path: $1', $destinationPath)
                              );
                          }
                          $imagePath = 'mediaimage'.$result['file'];
                          //Set file path with name for save into database
                          $data['image'] = $imagePath;
                      }catch (\Exception $exception){
                          $this->messageManager->addErrorMessage($exception->getMessage());
                      }


                      $brandModel->setData($data);
                      try {
                          $this->brandResource->save($brandModel);
                          $this->messageManager->addSuccessMessage('Data Saved Successfully');

                      }catch (\Exception $exception){
                          $this->messageManager->addErrorMessage(_('Data Not Saved Successfully'));
                      }
                  }

                  $redirect = $this->resultRedirectFactory->create();
                  $redirect->setPath('form');
                  return $redirect;
              }
              else{
                  $this->messageManager->addErrorMessage(_('Email is Already Exit Try With New Email'));
                  $redirect = $this->resultRedirectFactory->create();
                  $redirect->setPath('form');
                  return $redirect;
              }
        }

//        var_dump($dbEmail);
//        var_dump($dbPhone);

//        echo '----';

//        var_dump($email);
//        var_dump($phone);

//        die('--');

//        /** Set The Data into Model */
//        $brandModel = $this->brand;

//        if (isset($file['image']) && !empty($file['image']['name'])){
//
//            try {
//                $uploaderFactory = $this->uploaderFactory->create(['fileId' => 'image']);
//                $uploaderFactory->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
//                $uploaderFactory->setAllowRenameFiles(true);
//                $uploaderFactory->setFilesDispersion(true);
//                $mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
//                $destinationPath = $mediaDirectory->getAbsolutePath('mediaimage');
//                $result = $uploaderFactory->save($destinationPath);
//
//                if (!$result) {
//                    throw new LocalizedException(
//                        __('File cannot be saved to path: $1', $destinationPath)
//                    );
//                }
//                $imagePath = 'mediaimage'.$result['file'];
//                //Set file path with name for save into database
//                $data['image'] = $imagePath;
//            }catch (\Exception $exception){
//                $this->messageManager->addErrorMessage($exception->getMessage());
//            }
//
//
//            $brandModel->setData($data);
//            try {
//                $this->brandResource->save($brandModel);
//                $this->messageManager->addSuccessMessage('Data Saved Successfully');
//
//            }catch (\Exception $exception){
//                $this->messageManager->addErrorMessage(_('Data Not Saved Successfully'));
//            }
//        }
//
//        $redirect = $this->resultRedirectFactory->create();
//        $redirect->setPath('form');
//        return $redirect;
    }
}

