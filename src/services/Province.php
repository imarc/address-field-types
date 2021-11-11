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
use imarc\addressfieldtypes\services\Base as BaseService;
use imarc\addressfieldtypes\services\Country as CountryService;

use Craft;

/**
 * @author    Imarc
 * @package   AddressFieldTypes
 * @since     1.0.0
 */
class Province extends BaseService
{
    // Public Methods
    // =========================================================================

    public function getData($country_code=null)
    {
        if (empty($country_code)) {
            return [];
        }

        $country = (new CountryService)->getCountry($country_code);

        if (empty($country)) {
            return [];
        }

        $subs = $this->isoCodesFactory()->getSubdivisions()->getAllByCountryCode($country['alpha2']);

        $divisions = [];

        foreach ($subs as $sub) {
            $code = substr($sub->getCode(), -2, 2);
            $divisions[$code] = [
                'code' => $code,
                'name' => $sub->getLocalName(),
                'type' => $sub->getType(),
                'parent' => $sub->getParent()
            ];
        }

        return $divisions;
    }
}