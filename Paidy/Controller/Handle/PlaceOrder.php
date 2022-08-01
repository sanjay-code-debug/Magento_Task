<?php
declare(strict_types=1);

namespace CasioJP\Paidy\Controller\Handle;

use Magento\Framework\Exception\LocalizedException;

/**
 * Override Controller Class   
 * 
 *   
 *     Only we need to extends the Parent Class  and put the Parent Class Method and Make your Chnage 
 * 
 */
class PlaceOrder extends \BBox\Paidy\Controller\Handle\PlaceOrder
{

    //This is the Parent Class Method  - changing the last Else Condition
    protected function _getOrder($incrementId, $paymentId)
    {
        $count = 0;
        $order = $this->_orderFactory->create()->loadByIncrementId($incrementId);
        if ($order->getId()) {
            return $order;
        } else {
            if ($this->_retryCount < 3) {
                sleep(2);
                $this->_retryCount++;
                return $this->_getOrder($incrementId, $paymentId);
            }
            else {
                $response = $this->_checkPayment($paymentId);
                if (isset($response['ErrCode']) || $response['status'] == 'rejected') {
                    throw new LocalizedException(__("Paidy payment was declined. Please select another payment method"));
                }
                return $order;
            }
        }
    }
}
