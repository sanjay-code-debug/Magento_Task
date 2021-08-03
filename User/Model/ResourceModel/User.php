<?php

namespace Codilar\User\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
/**
 * class FAQ
 */
class User extends AbstractDb
{
    const MAIN_TABLE = 'user_information';
    const ID_FIELD_NAME = 'id';

    /**
     *  assigning the table and id
     */
    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, self::ID_FIELD_NAME);
    }
}
