<?php

namespace Codilar\Event_Observer_Example\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class Product implements ObserverInterface
{

    public function execute(Observer $observer)
    {
       $collection = $observer->getEvent()->getData('collection');

       foreach ($collection as $product){
           $price =$product->getData('price');
           $name = $product->getData('name');

           if ($price<20){
               $name = "Change";
           }
           else{
               $name = "No Change";
           }
           $product->setData('name',$name);
       }
    }
}
