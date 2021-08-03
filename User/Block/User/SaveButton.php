<?php

namespace Codilar\User\Block\User;
use Magento\CatalogRule\Block\Adminhtml\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class SaveButton extends GenericButton implements ButtonProviderInterface
{
    /**
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => [
                    'buttonAdapter' => [
                        'actions' => [
                            [
                                'targetName' => 'template_add_ui.template_add_ui',
                                'params' => [
                                    false
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}
