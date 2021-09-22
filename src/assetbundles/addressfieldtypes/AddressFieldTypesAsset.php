<?php
/**
 * Address Field Types plugin for Craft CMS 3.x
 *
 * Creates state/province, country, and postal code field types  for the CMS
 *
 * @link      https://www.imarc.com
 * @copyright Copyright (c) 2021 Imarc
 */

namespace imarc\addressfieldtypes\assetbundles\addressfieldtypes;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Imarc
 * @package   AddressFieldTypes
 * @since     1.0.0
 */
class AddressFieldTypesAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@imarc/addressfieldtypes/assetbundles/addressfieldtypes/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/AddressFieldTypes.js',
        ];

        $this->css = [
            'css/AddressFieldTypes.css',
        ];

        parent::init();
    }
}
