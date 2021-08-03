<?php

namespace Codilar\PushNotification\Model;

use Codilar\PushNotification\Model\ResourceModel\NotificationTemplate as ResourceModel;
use Magento\Framework\Model\AbstractModel;


class NotificationTemplate extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
