<?php

namespace Codilar\InternationalTelephoneInput\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Magento\Framework\Serialize\Serializer\Json;

class PhoneNumber extends Template
{

    /**
     * @var Json
     */
    protected $jsonHelper;

    /**
     * PhoneNumber constructor.
     * @param Context $context
     * @param Json $jsonHelper
     */
    public function __construct(
        Context $context,
        Json $jsonHelper
    )
    {
        $this->jsonHelper = $jsonHelper;
        parent::__construct($context);
    }

    /**
     * @return bool|string
     */
    public function phoneConfig()
    {
        $config  = [
            "nationalMode" => false,
            "utilsScript"  => $this->getViewFileUrl('Codilar_InternationalTelephoneInput::js/utils.js'),
            "preferredCountries" => []
        ];

        return $this->jsonHelper->serialize($config);
    }
}
