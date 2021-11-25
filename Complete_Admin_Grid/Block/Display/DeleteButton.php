<?php

namespace Codilar\Demo\Block\Display;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        if (!$this->getId()) {
            return [];
        }
        return [
            'label' => __('Delete User'),
            'class' => 'delete',
            'on_click' => 'deleteConfirm( \'' . __(
                    'Are you sure you want to delete this kyc?'
                ) . '\', \'' . $this->getDeleteUrl() . '\')',
            'sort_order' => 20,
        ];
    }
}
