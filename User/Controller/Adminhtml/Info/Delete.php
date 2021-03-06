<?php

namespace Codilar\User\Controller\Adminhtml\Info;
use Codilar\User\Api\UserRepositoryInterface;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\App\ActionInterface;

class Delete implements ActionInterface
{
    private $resultFactory;
    private $userRepository;
    private $request;
    private $url;
    private $manager;
    /**
     * Index constructor.
     * @param ResultFactory $resultFactory
     * @param RequestInterface $request
     * @param UserRepositoryInterface $userRepository
     * @param ManagerInterface $manager
     * @param UrlInterface $url
     */

    public function __construct(
        ResultFactory $resultFactory,
        RequestInterface $request,
        UserRepositoryInterface $userRepository,
        ManagerInterface $manager,
        UrlInterface $url
    ) {
        $this->resultFactory = $resultFactory;
        $this->userRepository = $userRepository;
        $this->request = $request;
        $this->url = $url;
        $this->manager = $manager;
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        $redirectResponse = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $redirectResponse->setUrl($this->url->getUrl('*/*/index'));
        $result = $this->userRepository->deleteById($this->request->getParam('id'));
        if($result) {
            $this->manager->addSuccessMessage(
                __(sprintf(
                        'The FAQ with id %s has been deleted Successfully',
                        $this->request->getParam('id')
                    )
                )
            );
        } else {
            $this->manager->addErrorMessage(
                __(sprintf(
                        'The FAQ with id %s has not been deleted, Due to some technical reasons',
                        $this->request->getParam('id')
                    )
                )
            );
        }
        return $redirectResponse;
    }
}
