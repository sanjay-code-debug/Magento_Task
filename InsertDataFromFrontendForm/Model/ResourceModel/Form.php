<?php


namespace Codilar\FormDataInsertToAdminGrid\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Form extends AbstractDb
{
    const MAIN_TABLE = 'Form_Data';
    const ID_FIELD_NAME = 'id';

    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, self::ID_FIELD_NAME);
    }
}
