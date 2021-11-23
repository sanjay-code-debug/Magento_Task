<?php

namespace Codilar\FormDataInsertToAdminGrid\Model;

use Magento\Framework\Model\AbstractModel;

class Form extends AbstractModel{

       protected function _construct()
       {
           $this->_init(ResourceModel\Form::class);
       }
}
