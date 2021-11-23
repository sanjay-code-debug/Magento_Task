<?php


namespace Codilar\FormDataInsertToAdminGrid\Model\ResourceModel\Form;


use Codilar\FormDataInsertToAdminGrid\Model\Form;
use Codilar\FormDataInsertToAdminGrid\Model\ResourceModel\Form as FormResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Form::class, FormResourceModel::class);
    }
}
