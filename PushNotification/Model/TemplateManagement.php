<?php

namespace Codilar\PushNotification\Model;

use Codilar\PushNotification\Api\TemplateManagementInterface;
use Codilar\PushNotification\Model\NotificationTemplate as Model;
use Codilar\PushNotification\Model\NotificationTemplateFactory as ModelFactory;
use Codilar\PushNotification\Model\ResourceModel\NotificationTemplate as ResourceModel;
use Codilar\PushNotification\Model\ResourceModel\NotificationTemplate\Collection as Collection;
use Codilar\PushNotification\Model\ResourceModel\NotificationTemplate\CollectionFactory;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\LocalizedException;


class TemplateManagement implements TemplateManagementInterface
{
    /**
     * @var ModelFactory
     */
    private $modelFactory;
    /**
     * @var ResourceModel
     */
    private $resourceModel;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * TokenManagement constructor.
     * @param ModelFactory $modelFactory
     * @param ResourceModel $resourceModel
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        ModelFactory $modelFactory,
        ResourceModel $resourceModel,
        CollectionFactory $collectionFactory
    ) {
        $this->modelFactory = $modelFactory;
        $this->resourceModel = $resourceModel;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @inheritDoc
     */
    public function getDataBYId($id)
    {
        return $this->load($id);
    }


    /**
     * @inheritDoc
     * @throws AlreadyExistsException
     */
    public function save(Model $model)
    {
        $this->resourceModel->save($model);
        return $model;
    }

    /**
     * @inheritDoc
     */
    public function load($value, $field = null)
    {
        $model = $this->create();
        $this->resourceModel->load($model, $value, $field);
        return $model;
    }

    /**
     * @inheritDoc
     */
    public function create()
    {
        return $this->modelFactory->create();
    }

    /**
     * @inheritDoc
     * @throws LocalizedException
     */
    public function delete(Model $model)
    {
        try {
            $this->resourceModel->delete($model);
        } catch (\Exception $exception) {
            return false;
        }
        return $this;
    }

    /**
     * @return Collection
     */
    public function getCollection()
    {
        return $this->collectionFactory->create();
    }

    /**
     * @inheritDoc
     * @throws LocalizedException
     */
    public function deleteById($id)
    {
        $model = $this->load($id);
        return $this->delete($model);
    }
}
