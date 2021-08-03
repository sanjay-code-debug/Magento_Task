<?php

namespace Codilar\Custom404Page\Controller\Category;

  use Magento\Framework\Exception\NoSuchEntityException;

  class View extends \Magento\Cms\Controller\Index\Index
  {

      /**
       * @param null $coreRoute
       * @return bool|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Forward|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page|void
       */
	public function execute($coreRoute = null) {

		$pageId = (int)$this->getRequest()->getParam('id', false);
		if (!$pageId) {
//		    die("Hitt");
			return $this->_forward('index', 'categorynoroute', 'custom404Page');
		}

		try {
			$page = $this->categoryRepository->get($pageId, $this->_storeManager->getStore()->getId());
		} catch (NoSuchEntityException $e) {
			return $this->_forward('index', 'categorynoroute', 'custom404Page');
		}

		if (!$this->_objectManager->get('Magento\Cms\Helper\Page')->canShow($page)) {
			return $this->_forward('index', 'categorynoroute', 'custom404Page');
		}
		return parent::execute($coreRoute);
	}
  }
