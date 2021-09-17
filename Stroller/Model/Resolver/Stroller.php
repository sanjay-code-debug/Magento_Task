<?php

namespace  Codilar\Stroller\Model\Resolver;

use Codilar\Stroller\Block\Homepage;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class  Stroller implements ResolverInterface{

    /**
     * @var Homepage
     */
     private  $block;

    /**
     * @param Homepage $block
     */
     public function  __construct(Homepage $block){
         $this->block=$block;
     }

    /**
     * @param Field $field
     * @param \Magento\Framework\GraphQl\Query\Resolver\ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return \Magento\Framework\GraphQl\Query\Resolver\Value|mixed|void
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null){
          global $ar;
          $ar =array();

        $curr = $this->block->getCurrentCurrencyCode();
        foreach($this->block->getSliderProducts() as $k=> $v) {
            $product =$this->block->getProductBySku($v['product_sku']);
              $name = $product->getName();
              $min  = $this->block->getFormatedPrice($v['min_price'],$curr);
              $max = $this->block->getFormatedPrice($v['max_price'],$curr);
              $ar[] =['product_sku_name'=>$name, 'min_product_price'=>$min, 'max_product_price'=>$max];
        }
        return $ar;
    }
   }

?>
