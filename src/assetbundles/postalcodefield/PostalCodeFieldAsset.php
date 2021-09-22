<?php
/**
 * Address Field Types plugin for Craft CMS 3.x
 *
 * Creates state/province, country, and postal code field types  for the CMS
 *
 * @link      https://www.imarc.com
 * @copyright Copyright (c) 2021 Imarc
 */

namespace imarc\addressfieldtypes\assetbundles\postalcodefield;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Imarc
 * @package   AddressFieldTypes
 * @since     1.0.0
 */
class PostalCodeFieldAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@imarc/addressfieldtypes/assetbundles/postalcodefield/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/PostalCode.js',
        ];

        $this->css = [
            'css/PostalCode.css',
        ];

        parent::init();
    }
}
