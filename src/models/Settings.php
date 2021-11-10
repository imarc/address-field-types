<?php
/**
 * Address Field Types plugin for Craft CMS 3.x
 *
 * Creates state/province, country, and postal code field types  for the CMS
 *
 * @link      https://www.imarc.com
 * @copyright Copyright (c) 2021 Imarc
 */

namespace imarc\addressfieldtypes\models;

use imarc\addressfieldtypes\AddressFieldTypes;

use Craft;
use craft\base\Model;

/**
 * @author    Imarc
 * @package   AddressFieldTypes
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $country = [
                        'valueFormat' => '',
                        'filters' => null
                    ];

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    // public function rules()
    // {
    //     return [
    //         ['someAttribute', 'string'],
    //         ['someAttribute', 'default', 'value' => 'Some Default'],
    //     ];
    // }
}
