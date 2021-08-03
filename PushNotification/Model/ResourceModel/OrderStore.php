<?php

namespace Codilar\PushNotification\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * class OrderTemplate
 *
 * @description OrderTemplate
 * @author   Codilar Team Player <ankith@codilar.com>
 * @license  Open Source
 * @link     https://www.codilar.com
 * @copyright Copyright © 2020 Codilar Technologies Pvt. Ltd.. All rights reserved
 *
 * ResourceModel for Template
 */

class OrderStore extends AbstractDb
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('codilar_push_notification_order_store', 'id');
    }
}
