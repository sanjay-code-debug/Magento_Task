<?php

namespace Codilar\PluginExample\Plugin;

class  Product
{
    /**
     * @param \Magento\Catalog\Model\Product $product
     * @param $name
     * @return string
     */
    public function aftergetName(\Magento\Catalog\Model\Product $product, $name){
        $price = $product->getData('price');
        if ($price<1000){
            $name ="Sanjay";
        }
        else{
            $name = "Nothing";
        }
        return $name;
    }
}
