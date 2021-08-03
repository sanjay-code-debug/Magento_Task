<?php

namespace Codilar\Custom404Page\Block;

 class CategoryNoRoute extends \Magento\Framework\View\Element\Template
 {
	/**
	* @param \Magento\Framework\View\Element\Template\Context $context
	*/
	public function __construct(\Magento\Framework\View\Element\Template\Context $context) {
		parent::__construct($context);
	}

	/**
	* @return $this
	*/
	public function _prepareLayout() {
		return parent::_prepareLayout();
	}
  }
