<?php


namespace Codilar\Demo\Model\ResourceModel\BrandsInfo;

use Codilar\Demo\Model\BrandsInfo;
use Codilar\Demo\Model\ResourceModel\BrandsInfo as BrandsResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * class Collection
 *
 * @description A magento 2 module to have Brands
 * @copyright Copyright © 2021 Codilar Technologies Pvt. Ltd.. All rights reserved
 *
 * A magento 2 module to have Brands for products
 */

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(BrandsInfo::class, BrandsResource::class);
    }
}


