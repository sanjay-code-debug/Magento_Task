<?php

namespace Codilar\PushNotification\Model;

use Codilar\PushNotification\Model\ResourceModel\OrderStore as ResourceModel;
use Magento\Framework\Model\AbstractModel;


class OrderStore extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
