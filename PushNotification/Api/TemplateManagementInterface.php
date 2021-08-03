<?php

namespace Codilar\PushNotification\Api;

use Codilar\PushNotification\Model\NotificationTemplate as Model;
use Codilar\PushNotification\Model\ResourceModel\NotificationTemplate\Collection as Collection;


interface TemplateManagementInterface
{
    /**
     * @param $id
     * @return Model
     */
    public function getDataBYId($id);

    /**
     * @param Model $model
     * @return Model
     */
    public function save(Model $model);

    /**
     * @param Model $model
     * @return Model
     */
    public function delete(Model $model);

    /**
     * @param $value
     * @param null $field
     * @return Model
     */
    public function load($value, $field = null);

    /**
     * @return Model $model
     */
    public function create();

    /**
     * @param int $id
     * @return Model
     */
    public function deleteById($id);

    /**
     * @return Collection
     */
    public function getCollection();
}
