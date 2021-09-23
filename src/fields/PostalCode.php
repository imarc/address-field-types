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
use imarc\addressfieldtypes\assetbundles\postalcodefield\PostalCodeFieldAsset;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Db;
use yii\db\Schema;
use craft\helpers\Json;

/**
 * @author    Imarc
 * @package   AddressFieldTypes
 * @since     1.0.0
 */
class PostalCode extends Field
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $someAttribute = null;

    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('address-field-types', 'PostalCode (Address Fields)');
    }

    // Public Methods
    // =========================================================================

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
    public function getContentColumnType(): string
    {
        return Schema::TYPE_STRING;
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
            'address-field-types/_components/fields/PostalCode_settings',
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
        Craft::$app->getView()->registerAssetBundle(PostalCodeFieldAsset::class);

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
        Craft::$app->getView()->registerJs("$('#{$namespacedId}-field').AddressFieldTypesPostalCode(" . $jsonVars . ");");

        // Render the input template
        return Craft::$app->getView()->renderTemplate(
            'address-field-types/_components/fields/PostalCode_input',
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
