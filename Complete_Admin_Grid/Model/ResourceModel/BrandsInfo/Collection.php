<?php


namespace Codilar\Demo\Model\ResourceModel\BrandsInfo;

use Codilar\Demo\Model\BrandsInfo;
use Codilar\Demo\Model\ResourceModel\BrandsInfo as BrandsResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;



class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(BrandsInfo::class, BrandsResource::class);
    }
}


