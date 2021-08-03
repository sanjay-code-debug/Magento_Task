<?php

namespace Codilar\Demo\Controller\Adminhtml\Info;

use Codilar\Demo\Api\BrandsRepositoryInterface;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Message\ManagerInterface;

class Delete implements ActionInterface
{
    private $resultFactory;
    private $request;
    private $url;
    private $brandsRepository;
    private $manager;

    /**
     * Save constructor.
     * @param ResultFactory $resultFactory
     * @param RequestInterface $request
     * @param BrandsRepositoryInterface $brandsRepository
     * @param ManagerInterface $manager
     * @param UrlInterface $url
     */
    public function __construct(
        ResultFactory $resultFactory,
        RequestInterface $request,
        BrandsRepositoryInterface $brandsRepository,
        ManagerInterface $manager,
        UrlInterface $url
    ) {
        $this->resultFactory = $resultFactory;
        $this->request = $request;
        $this->url = $url;
        $this->brandsRepository = $brandsRepository;
        $this->manager = $manager;
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        $redirectResponse = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $redirectResponse->setUrl($this->url->getUrl('brand/info/index'));
        $result = $this->brandsRepository->deleteById($this->request->getParam('id'));
        if ($result) {
            $this->manager->addSuccessMessage(
                __(sprintf(
                    'The Brands with id %s has been deleted Successfully',
                    $this->request->getParam('id')
                ))
            );
        } else {
            $this->manager->addErrorMessage(
                __(sprintf(
                    'The Brands with id %s has not been deleted, Due to some technical reasons',
                    $this->request->getParam('id')
                ))
            );
        }
        return $redirectResponse;
    }
}
