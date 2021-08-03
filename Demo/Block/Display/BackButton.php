<?php

namespace Codilar\Demo\Block\Display;

use Magento\Cms\Block\Adminhtml\Block\Edit\BackButton as MagentoBackButton;

/**
 * class BackButton
 *
 * @description BackButton
 * @license  Open Source
 * @link     https://www.codilar.com
 * @copyright Copyright © 2020 Codilar Technologies Pvt. Ltd.. All rights reserved
 *
 * Provides Method for going back from the Current Page
 */

class BackButton extends MagentoBackButton
{
    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('brand/info/index');
    }
}
