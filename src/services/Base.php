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

use Sokil\IsoCodes\IsoCodesFactory;
use Sokil\IsoCodes\TranslationDriver\DummyDriver;

use Craft;
use craft\base\Component;

/**
 * @author    Imarc
 * @package   AddressFieldTypes
 * @since     1.0.0
 */
class Base extends Component
{
    protected $iso_codes_factory = null;

    public function isoCodesFactory()
    {
        if (empty($this->iso_codes_factory)) {
            $this->iso_codes_factory = new IsoCodesFactory(null, new DummyDriver());
        }

        return $this->iso_codes_factory;
    }
}