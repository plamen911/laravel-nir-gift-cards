<?php

namespace App\Helpers;

class UtilityHelper
{
    /**
     * @return array
     */
    public function getStates()
    {
        return [
            '' => 'Select State', 'International' => 'International', 'AK' => 'Alaska', 'AL' => 'Alabama', 'AR' => 'Arkansas',
            'AZ' => 'Arizona', 'CA' => 'California', 'CO' => 'Colorado', 'CT' => 'Connecticut',
            'DC' => 'District of Columbia', 'DE' => 'Delaware', 'FL' => 'Florida', 'GA' => 'Georgia',
            'HI' => 'Hawaii', 'IA' => 'Iowa', 'ID' => 'Idaho', 'IL' => 'Illinois',
            'IN' => 'Indiana', 'KS' => 'Kansas', 'KY' => 'Kentucky', 'LA' => 'Louisiana',
            'MA' => 'Massachusetts', 'MD' => 'Maryland', 'ME' => 'Maine', 'MI' => 'Michigan',
            'MN' => 'Minnesota', 'MO' => 'Missouri', 'MS' => 'Mississippi', 'MT' => 'Montana',
            'NC' => 'North Carolina', 'ND' => 'North Dakota', 'NE' => 'Nebraska', 'NH' => 'New Hampshire',
            'NJ' => 'New Jersey', 'NM' => 'New Mexico', 'NV' => 'Nevada', 'NY' => 'New York',
            'OH' => 'Ohio', 'OK' => 'Oklahoma', 'OR' => 'Oregon', 'PA' => 'Pennsylvania',
            'RI' => 'Rhode Island', 'SC' => 'South Carolina', 'SD' => 'South Dakota', 'TN' => 'Tennessee',
            'TX' => 'Texas', 'UT' => 'Utah', 'VA' => 'Virginia', 'VT' => 'Vermont',
            'WA' => 'Washington', 'WI' => 'Wisconsin', 'WV' => 'West Virginia', 'WY' => 'Wyoming'
        ];
    }

    /**
     * @param string $db_date
     * @return string
     */
    public static function db2UsDate($db_date = '')
    {
        if (!empty($db_date)) {
            if ('0000-00-00' !== substr($db_date, 0, 10) &&
                '1970-01-01' !== substr($db_date, 0, 10) &&
                false !== $ts = strtotime($db_date)
            ) {
                return date('m/d/Y', $ts);
            }
        }

        return '';
    }

    public function getGiftCardAmounts()
    {
        return [
            '25' => '25.00',
            '50' => '50.00',
            '100' => '100.00',
            '150' => '150.00',
            '200' => '200.00',
            '250' => '250.00',
            '300' => '300.00',
            '350' => '350.00',
            '400' => '400.00',
            '500' => '500.00',
            '1000' => '1,000.00',
            '2500' => '2,500.00',
            '5000' => '5,000.00',
            'Custom Amount' => 'Custom Amount'
        ];
    }

    public function getCreditCardTypes()
    {
        return [
            '' => 'Select Card',
            'AmEx' => 'American Express',
            'DinersClub' => 'Diners Club',
            'Discover' => 'Discover',
            'MasterCard' => 'MasterCard',
            'Visa' => 'Visa'
        ];
    }
}