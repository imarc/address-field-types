<?php
/**
 * Address Field Types plugin for Craft CMS 3.x
 *
 * Creates state/province, country, and postal code field types  for the CMS
 *
 * @link      https://www.imarc.com
 * @copyright Copyright (c) 2021 Imarc
 */

namespace imarc\addressfieldtypes\fields;

use imarc\addressfieldtypes\AddressFieldTypes;
use imarc\addressfieldtypes\assetbundles\countryfield\CountryFieldAsset;
use imarc\addressfieldtypes\services\Country;

use Craft;
//use craft\base\ElementInterface;
use craft\fields\Dropdown;

/**
 * @author    Imarc
 * @package   AddressFieldTypes
 * @since     1.0.0
 */
class Country extends Dropdown
{
    // Public Properties
    // =========================================================================

    /**
     * Valid values: alpha2, alpha3, numeric (3 digit country code), name
     * 
     * @var string
     */
    public $valueFormat = 'alpha2';

    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('address-field-types', 'Country');
    }

    // Public Methods
    // =========================================================================


    public function init()
    {
        $this->setSelectFieldValues();

        parent::init();
    }



    /**
     * Sets the select menu option values
     */
    public function setSelectFieldValues()
    {
        $countries = (new Country)->getData($this->valueFormat);

        // prepare the field's display options
        $this->options = [
            [
                'label' => Craft::t('site', 'Choose a Country'),
                'value' => '',
                'disabled' => true,
            ]
        ];

        // add Commerce's countries as options
        foreach ($countries as $key => $country) {

            $this->options[] = [
                'label' => Craft::t('site', $country['name']),
                'value' => $key
            ];
        }
    }

    /**
     * @inheritdoc
     */
    /**
    public function rules()
    {
        $rules = parent::rules();
        $rules = array_merge($rules, [
            ['someAttribute', 'string'],
            ['someAttribute', 'default', 'value' => 'Some Default'],
        ]);
        return $rules;
    }
    /**/

    /**
     * @inheritdoc
     */
    /**
    public function normalizeValue($value, ElementInterface $element = null)
    {
        return $value;
    }
    /**/

    /**
     * @inheritdoc
     */
    /**
    public function serializeValue($value, ElementInterface $element = null)
    {
        return parent::serializeValue($value, $element);
    }
    /**/

    /**
     * @inheritdoc
     */
    /**
    public function getSettingsHtml()
    {
        // Render the settings template
        return Craft::$app->getView()->renderTemplate(
            'address-field-types/_components/fields/Country_settings',
            [
                'field' => $this,
            ]
        );
    }
    /**/

    /**
     * @inheritdoc
     */
    /**
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        // Register our asset bundle
        Craft::$app->getView()->registerAssetBundle(CountryFieldAsset::class);

        // Get our id and namespace
        $id = Craft::$app->getView()->formatInputId($this->handle);
        $namespacedId = Craft::$app->getView()->namespaceInputId($id);

        // Variables to pass down to our field JavaScript to let it namespace properly
        $jsonVars = [
            'id' => $id,
            'name' => $this->handle,
            'namespace' => $namespacedId,
            'prefix' => Craft::$app->getView()->namespaceInputId(''),
            ];
        $jsonVars = Json::encode($jsonVars);
        Craft::$app->getView()->registerJs("$('#{$namespacedId}-field').AddressFieldTypesCountry(" . $jsonVars . ");");

        // Render the input template
        return Craft::$app->getView()->renderTemplate(
            'address-field-types/_components/fields/Country_input',
            [
                'name' => $this->handle,
                'value' => $value,
                'field' => $this,
                'id' => $id,
                'namespacedId' => $namespacedId,
            ]
        );
    }
    /**/
}
