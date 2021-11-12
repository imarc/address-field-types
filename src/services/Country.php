<?php
/**
 * Address Field Types plugin for Craft CMS 3.x
 *
 * Creates state/province, country, and postal code field types  for the CMS
 *
 * @link      https://www.imarc.com
 * @copyright Copyright (c) 2021 Imarc
 */

namespace imarc\addressfieldtypes\services;

use imarc\addressfieldtypes\AddressFieldTypes;
use imarc\addressfieldtypes\fields\Country as CountryField;
use imarc\addressfieldtypes\services\Base as BaseService;

//use League\ISO3166\ISO3166 as League;

use Craft;

/**
 * @author    Imarc
 * @package   AddressFieldTypes
 * @since     1.0.0
 */
class Country extends BaseService
{
    // Public Methods
    // =========================================================================

    /*
     * For use with League country library
     * @param  string  $values_format  Valid values: alpha2, alpha3, numeric (3 digit country code), name
     * 
     * @return object A data object that implements an iterator returning array data     
     * 
     * Data sample:
     * key => [
     *      'name' => 'Netherlands',
     *      'alpha2' => 'NL',
     *      'alpha3' => 'NLD',
     *      'numeric' => '528',
     *      'currency' => [
     *              'EUR',
     *          ]
     *      ]
     *
    public function getData($values_format=null)
    {
        if (empty($values_format)) {
            $values_format = $this->defaultFormat();
        }

        $iterator = (new League)->iterator($values_format);

        return iterator_to_array($iterator);
    }
    /**/


    protected function formatCountry($country)
    {
        return [
            'name' => $country->getLocalName(),
            'alpha2' => $country->getAlpha2(),
            'alpha3' => $country->getAlpha3(),
            'numeric' => $country->getNumericCode()
        ];
    }

    /*
     * @param  string  $values_format  Valid values: alpha2, alpha3, numeric (3 digit country code), name
     * 
     * @return object A data object that implements an iterator returning array data     
     * 
     * Data sample:
     * key => [
     *      'name' => 'Netherlands',
     *      'alpha2' => 'NL',
     *      'alpha3' => 'NLD',
     *      'numeric' => '528',
     */
    public function getData($values_format=null)
    {
        $countries = $this->isoCodesFactory()->getCountries();

        $data = [];

        if (empty($values_format) || !in_array($values_format, ['name', 'alpha2', 'alpha3', 'numeric'])) {
            $values_format = $this->defaultFormat();
        }

        foreach ($countries as $country) {
            $temp = $this->formatCountry($country);

            switch($values_format) {
                case 'name':
                    $key = $temp['name'];
                    break;
                case 'alpha2':
                    $key = $temp['alpha2'];
                    break;
                case 'alpha3':
                    $key = $temp['alpha3'];
                    break;
                case 'numeric':
                    $key = $temp['numeric'];
                    break;
            }

            $data[$key] = $temp;
        }

        return $data;
    }

    public function defaultFormat()
    {
        return (new CountryField)->valueFormat;
    }

    /**
     * Accepts an alpha-2, alpha-3, or numeric country code and returns the correct country object
     **/
    public function getCountry($country_code)
    {
        if (is_numeric($country_code)) {
            $country = $this->isoCodesFactory()->getCountries()->getByNumericCode($country_code);
        } else if (strlen($country_code) === 3) {
            $country = $this->isoCodesFactory()->getCountries()->getByAlpha3($country_code);
        } else {
            $country = $this->isoCodesFactory()->getCountries()->getByAlpha2($country_code);
        }


        if ($country) {
            return $this->formatCountry($country);
        }

        return null;
    }
}