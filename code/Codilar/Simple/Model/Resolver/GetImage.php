<?php

namespace  Codilar\Simple\Model\Resolver;


use Magento\Framework\App\ObjectManager;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class GetImage implements ResolverInterface {


    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $product_id = 2549;
        $objectManager = ObjectManager::getInstance();
        $product = $objectManager->create('Magento\Catalog\Model\Product')->load($product_id);

        $attributeCode ='custom_attr_field';
        $attribute_value = $product->getData($attributeCode);

        $ar[]=['product_image'=>$attribute_value];
        return $ar;
    }
}
