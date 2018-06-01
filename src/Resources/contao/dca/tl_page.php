<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2016 Heimrich & Hannot GmbH
 *
 * @package youtube
 * @author  Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

$arrDca = &$GLOBALS['TL_DCA']['tl_page'];

/**
 * Selectors
 */
$arrDca['palettes']['__selector__'][] = 'youtubePrivacy';

/**
 * Palettes
 */
$replace = 'adminEmail;{youtube_legend},youtube_template,youtubePrivacy;';

$arrDca['palettes']['root'] = str_replace('adminEmail;', $replace, $arrDca['palettes']['root']);

/**
 * Subpalettes
 */
$arrDca['subpalettes']['youtubePrivacy'] = 'youtubePrivacyTemplate';


/**
 * Fields
 */
$arrFields = [
    'youtube_template'       => [
        'label'            => &$GLOBALS['TL_LANG']['tl_page']['youtube_template'],
        'default'          => 'youtube_default',
        'exclude'          => true,
        'inputType'        => 'select',
        'options_callback' => function (\Contao\DataContainer $dc) {
            return System::getContainer()->get('huh.utils.choice.twig_template')->setContext(['youtube_video_'])->getCachedChoices();
        },
        'eval'             => ['tl_class' => 'w50'],
        'sql'              => "varchar(64) NOT NULL default ''",
    ],
    'youtubePrivacy'         => [
        'label'     => &$GLOBALS['TL_LANG']['tl_page']['youtubePrivacy'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['submitOnChange' => true, 'tl_class' => 'clr'],
        'sql'       => "char(1) NOT NULL default ''",
    ],
    'youtubePrivacyTemplate' => [
        'label'            => &$GLOBALS['TL_LANG']['tl_page']['youtubePrivacyTemplate'],
        'exclude'          => true,
        'inputType'        => 'select',
        'default'          => 'youtube_privacy_default',
        'options_callback' => function (\Contao\DataContainer $dc) {
            return System::getContainer()->get('huh.utils.choice.twig_template')->setContext(['youtube_privacy_'])->getCachedChoices();
        },
        'eval'             => ['tl_class' => 'w50', 'mandatory' => true],
        'sql'              => "varchar(64) NOT NULL default ''",
    ],
];

$arrDca['fields'] = array_merge($arrDca['fields'], $arrFields);