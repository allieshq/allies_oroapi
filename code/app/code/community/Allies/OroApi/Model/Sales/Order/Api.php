<?php

class Allies_OroApi_Model_Sales_Order_Api
    extends Oro_Api_Model_Sales_Order_Api 
{
    /**
     * @param Order $order
     * @return array
     */
    protected function _getOrderData($order)
    {
        $orderData = parent::_getOrderData($order);
        
        foreach (array('shipping_address', 'billing_address') as $k) {
            $orderData[$k]['street2'] = '';
            $orderData[$k]['street3'] = '';
            if (isset($orderData[$k]['street']) && is_string($orderData[$k]['street'])) {
                $streets = array_filter(array_map('trim', explode(PHP_EOL, $orderData[$k]['street'])));

                $orderData[$k]['street'] = (!empty($streets)) ? array_shift($streets) : '';
                $orderData[$k]['street2'] = (!empty($streets)) ? array_shift($streets) : '';
                $orderData[$k]['street3'] = (!empty($streets)) ? implode(', ', $streets) : '';
            }
        }
        
        if (!isset($orderData['attributes'])) {
            $orderData['attributes'] = array();
        }
        $orderData['attributes'] = array_merge(
                $orderData['attributes'],
                $this->_getAlliesOrderAdditionalAttributesInfo($order)
            );
        
        return $orderData;
    }
    
    /**
     * @param Order $order
     * @return array
     */
    protected function _getAlliesOrderAdditionalAttributesInfo($order)
    {
        $data = array(
            'state' => $order->getState(),
            'coupon_rule_name' => $order->getCouponRuleName(),
            'discount_description' => $order->getDiscountDescription(),
            'shipping_description' => $order->getShippingDescription(),
            
            'hidden_tax_amount' => (is_null($order->getHiddenTaxAmount())) ? null : (float)$order->getHiddenTaxAmount(),
            'shipping_tax_amount' => (is_null($order->getShippingTaxAmount())) ? null : (float)$order->getShippingTaxAmount(),
            'shipping_hidden_tax_amount' => (is_null($order->getShippingHiddenTaxAmount())) ? null : (float)$order->getShippingHiddenTaxAmount(),
            'shipping_incl_tax' => (is_null($order->getShippingInclTax())) ? null : (float)$order->getShippingInclTax(),
            'surcharge_amount' => (is_null($order->getSurchargeAmount())) ? null : (float)$order->getSurchargeAmount(),
            'subtotal_incl_tax' => (is_null($order->getSubtotalInclTax())) ? null : (float)$order->getSubtotalInclTax(),
            'rewards_discount_amount' => (is_null($order->getRewardsDiscountAmount())) ? null : (float)$order->getRewardsDiscountAmount(),
            'rewards_discount_tax_amount' => (is_null($order->getRewardsDiscountTaxAmount())) ? null : (float)$order->getRewardsDiscountTaxAmount(),
            
            'mailchimp_campaign_id' => $order->getEbizmartsMagemonkeyCampaignId(),
            'osc_customercomment' => $order->getOnestepcheckoutCustomercomment(),
            'osc_customerfeedback' => $order->getOnestepcheckoutCustomerfeedback(),
        );
        
        $return = array();
        foreach ($data as $key => $value) {
            $return[] = array(
                'key' => $key,
                'value' => $value,
            );
        }
        
        return $return;
    }
}