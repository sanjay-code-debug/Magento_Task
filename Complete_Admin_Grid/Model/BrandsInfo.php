<?php


namespace Codilar\Demo\Model;

use Magento\Framework\Model\AbstractModel;
use Codilar\Demo\Model\ResourceModel\BrandsInfo as ResourceModel;

class BrandsInfo extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
