<?php

namespace Codilar\User\Model;
use Magento\Framework\Model\AbstractModel;
use Codilar\User\Model\ResourceModel\User as ResourceModel;

class User extends AbstractModel
{
    /**
     *  Getting ResourceModel
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
