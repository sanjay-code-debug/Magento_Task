<?php


namespace Codilar\Demo\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class BrandsInfo extends AbstractDb
{
    const MAIN_TABLE = 'demo';
    const ID_FIELD_NAME = 'id';


    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, self::ID_FIELD_NAME);
    }
}


