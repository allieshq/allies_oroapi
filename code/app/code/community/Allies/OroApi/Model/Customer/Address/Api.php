<?php

class Allies_OroApi_Model_Customer_Address_Api
    extends Oro_Api_Model_Customer_Address_Api
{
    /**
     * {@inheritdoc}
     */
    public function getAddressData($address, $customer = null) {
        $row = parent::getAddressData($address, $customer);
        
        $row['street2'] = "";
        $row['street3'] = "";
        if (isset($row['street']) && is_string($row['street'])) {
            $streets = array_filter(array_map('trim', explode(PHP_EOL, $row['street'])));

            $row['street'] = (!empty($streets)) ? array_shift($streets) : '';
            $row['street2'] = (!empty($streets)) ? array_shift($streets) : '';
            $row['street3'] = (!empty($streets)) ? implode(', ', $streets) : '';
        }
        
        return $row;
    }
}
