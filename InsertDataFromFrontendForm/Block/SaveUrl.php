<?php

namespace Codilar\FormDataInsertToAdminGrid\Block;
use Magento\Framework\View\Element\Template;

class SaveUrl extends Template
{
    public function __construct(
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     *   - Getting the Url For Save The Form Data into Database
     *   - form/save/save  - contain the logic for Save the data into Table
     *
     * @return string
     */
    public function getPostUrl()
    {
        return $this->getUrl('form/form/save');
    }
}
