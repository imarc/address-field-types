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
use imarc\addressfieldtypes\services\Country as CountryService;

use Craft;
use craft\base\ElementInterface;
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

    /**
     * Can be set to an ISO 3166-1 alpha-2, alpha-3, or numeric country code 
     * 
     * @var string
     */
    public $default = '';


    /**
     * Can be set to a comma separated string of ISO 3166-1 alpha-2, alpha-3, or numeric country codes
     * 
     * @var string
     */
    public $disabled = '';

    /**
     * The default country code formatted to match $valueFormat
     * 
     * @var string
     */
    private $defaultValue = '';

     /**
     * An array of disabled country codes formatted to match $valueFormat
     * 
     * @var string
     */
    private $disabledValues = [];

     /**
     * An array of disabled country codes formatted to match $valueFormat
     * 
     * @var string
     */
    public $countries = [];


    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('address-field-types', 'Country (Address Fields)');
    }


    // Private Methods
    // =========================================================================

    private function isDisabled($code)
    {        
        if (empty($this->disabledValues)) {
            return false;
        }

        return in_array($code, $this->disabledValues);
    }

    private function formatDisabledValues()
    {
        // Default country
        $this->defaultValue = $this->getValidFormat($this->default);

        // Disabled countries
        $codes = array_map('trim', explode(',', $this->disabled));

        foreach ($codes as $code) {
            $validCode = $this->getValidFormat($code);

            if ($validCode) {
                array_push($this->disabledValues, $validCode);
            }
        }
    }

    private function getValidFormat($code)
    {
        foreach ($this->countries as $key => $country) {
            if ($code === $country['alpha2']) {
                return $country[$this->valueFormat];
            }
            if ($code === $country['alpha3']) {
                return $country[$this->valueFormat];
            }
            if ($code === $country['numeric']) {
                return $country[$this->valueFormat];
            }
        }

        return '';
    }

    // Public Methods
    // =========================================================================

    public function init()
    {
        $this->countries = (new CountryService)->getData($this->valueFormat);

        $this->formatDisabledValues();
        $this->setSelectFieldValues();

        parent::init();
    }

    /**
     * Sets the select menu option values
     */
    public function setSelectFieldValues()
    {
        // prepare the field's display options
        $this->options = [
            [
                'label' => Craft::t('site', 'Choose a Country'),
                'value' => '',
            ]
        ];

        // add Commerce's countries as options
        foreach ($this->countries as $key => $country) {
            $opt = [
                'label' => Craft::t('site', $country['name']),
                'value' => $key
            ];

            if ($this->isDisabled($key)) {
                $opt['disabled'] = true;
            }
            
            array_push($this->options, $opt);
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
            ['valueFormat', 'string'],
            ['valueFormat', 'default', 'value' => $this->valueFormat],
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
        if (is_null($value)) {
            $value = $this->defaultValue;
        }
        return parent::serializeValue($value, $element);
    }
    /**/

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
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
        $jsonVars = json_encode($jsonVars);
        Craft::$app->getView()->registerJs("$('#{$namespacedId}-field').AddressFieldTypesCountry(" . $jsonVars . ");");

        // Overload the default value if null
        if (is_null($value->value)) {
            $value->value = $this->defaultValue;
        }

        // Render the input template
        return Craft::$app->getView()->renderTemplate(
            'address-field-types/_components/fields/Country_input',
            [
                'name' => $this->handle,
                'value' => $value,
                'field' => $this,
                'id' => $id,
                'namespacedId' => $namespacedId,
                'options' => $this->options,
            ]
        );
    }
}
