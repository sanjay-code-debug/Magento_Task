<?php

namespace Codilar\Demo\Model\Source;
use Magento\Framework\Option\ArrayInterface;


class Dropdown implements ArrayInterface
{
    /**
     * @return array[]
     */
    public function toOptionArray()
    {
        return [
            ['label' => __(''), 'value' => ''],
            ['label' => __('Zero'), 'value' => '0'],
            ['label' => __('One'), 'value' => '1'],
            ['label' => __('Two'), 'value' => '2'],
            ['label' => __('Three'), 'value' => '3']
        ];
    }
}
