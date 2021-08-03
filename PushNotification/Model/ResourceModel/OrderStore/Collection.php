<?php

namespace Codilar\PushNotification\Model\ResourceModel\OrderStore;

use Codilar\PushNotification\Model\OrderStore as Model;
use Codilar\PushNotification\Model\ResourceModel\OrderStore as ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;


class Collection extends AbstractCollection
{
    protected $_idFieldName = "id";
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
