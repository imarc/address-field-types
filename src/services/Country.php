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

use League\ISO3166\ISO3166 as LeagueService;

use Craft;
use craft\base\Component;

/**
 * @author    Imarc
 * @package   AddressFieldTypes
 * @since     1.0.0
 */
class Country extends Component
{
    // Public Methods
    // =========================================================================

    /*
     * @param  string  $valueFormat  Valid values: alpha2, alpha3, numeric (3 digit country code), name
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
     */
    public function getData($valueFormat)
    {
        return (new LeagueService)->iterator($valueFormat);
    }
}