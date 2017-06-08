<?php

class Allies_OroApi_Model_Sales_Quote_Api
    extends Oro_Api_Model_Sales_Quote_Api
{
    /**
     * {@inheritdoc}
     */
    protected function info($quote)
    {
        $result = parent::info($quote);
        
        foreach (array('shipping_address', 'billing_address') as $k) {
            $result[$k]['street2'] = '';
            $result[$k]['street3'] = '';
            if (isset($result[$k]['street']) && is_string($result[$k]['street'])) {
                $streets = array_filter(array_map('trim', explode(PHP_EOL, $result[$k]['street'])));

                $result[$k]['street'] = (!empty($streets)) ? array_shift($streets) : '';
                $result[$k]['street2'] = (!empty($streets)) ? array_shift($streets) : '';
                $result[$k]['street3'] = (!empty($streets)) ? implode(', ', $streets) : '';
            }
        }
        
        return $result;
    }
}