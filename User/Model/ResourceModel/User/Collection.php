<?php

namespace Codilar\User\Model\ResourceModel\User;

use Codilar\User\Model\User as Model;
use Codilar\User\Model\ResourceModel\User as ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
/**
 * class Collection
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
