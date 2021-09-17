<?php

namespace Codilar\Stroller\Block\Adminhtml;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class Products extends AbstractFieldArray
{
    /**
     * Prepare rendering the new field by adding all the needed columns
     */
    protected function _prepareToRender()
    {
        $this->addColumn('product_sku', ['label' => __('Product Sku'), 'class' => 'required-entry']);
        $this->addColumn('min_price', ['label' => __('Min Price'), 'class' => 'required-entry']);
        $this->addColumn('max_price', ['label' => __('Max Price'), 'class' => 'required-entry']);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }
}
