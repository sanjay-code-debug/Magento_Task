<?php

  namespace Codilar\Custom404Page\Controller\CategoryNoRoute;

  class Index extends \Magento\Framework\App\Action\Action
  {
	/**
	* @param \Magento\Framework\App\Action\Context $context
	*/
	public function __construct(\Magento\Framework\App\Action\Context $context) {
		parent::__construct($context);
	}

	 /**
	* @return void
	*/
	public function execute() {

		$this->_view->loadLayout();
		$this->_view->getLayout()->initMessages();
		$this->_view->renderLayout();
	}
  }
