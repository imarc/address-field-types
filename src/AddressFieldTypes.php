<?php
/**
 * Address Field Types plugin for Craft CMS 3.x
 *
 * Creates state/province, country, and postal code field types  for the CMS
 *
 * @link      https://www.imarc.com
 * @copyright Copyright (c) 2021 Imarc
 */

namespace imarc\addressfieldtypes;

use imarc\addressfieldtypes\services\Province as ProvinceService;
use imarc\addressfieldtypes\services\Country as CountryService;
use imarc\addressfieldtypes\services\PostalCode as PostalCodeService;
use imarc\addressfieldtypes\variables\AddressFieldTypesVariable;
use imarc\addressfieldtypes\models\Settings;
use imarc\addressfieldtypes\fields\Province as ProvinceField;
use imarc\addressfieldtypes\fields\Country as CountryField;
use imarc\addressfieldtypes\fields\PostalCode as PostalCodeField;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\services\Fields;
use craft\web\twig\variables\CraftVariable;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterUrlRulesEvent;

use yii\base\Event;

/**
 * Class AddressFieldTypes
 *
 * @author    Imarc
 * @package   AddressFieldTypes
 * @since     1.0.0
 *
 * @property  ProvinceService $province
 * @property  CountryService $country
 * @property  PostalCodeService $postalCode
 */
class AddressFieldTypes extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var AddressFieldTypes
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    /**
     * @var bool
     */
    public $hasCpSettings = true;

    /**
     * @var bool
     */
    public $hasCpSection = false;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['siteActionTrigger1'] = 'address-field-types/province';
                $event->rules['siteActionTrigger2'] = 'address-field-types/country';
                $event->rules['siteActionTrigger3'] = 'address-field-types/postal-code';
            }
        );

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['cpActionTrigger1'] = 'address-field-types/province/do-something';
                $event->rules['cpActionTrigger2'] = 'address-field-types/country/do-something';
                $event->rules['cpActionTrigger3'] = 'address-field-types/postal-code/do-something';
            }
        );

        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = ProvinceField::class;
                $event->types[] = CountryField::class;
                $event->types[] = PostalCodeField::class;
            }
        );

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('addressFieldTypes', AddressFieldTypesVariable::class);
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Craft::info(
            Craft::t(
                'address-field-types',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'address-field-types/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
