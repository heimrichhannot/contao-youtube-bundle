<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2015 Heimrich & Hannot GmbH
 *
 * @package youtube
 * @author  Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

$dc = &$GLOBALS['TL_DCA']['tl_content'];

$dc['config']['onload_callback'][] = ['huh.youtube.backend.content', 'modifyDca'];

/**
 * Selectors
 */
$dc['palettes']['__selector__'][] = 'addPreviewImage';

/**
 * Palettes
 */
$dc['palettes']['youtube'] = '{title_legend},type,name,headline;
	{video_legend},youtube,autoplay,videoDuration,ytHd,ytShowRelated,ytModestBranding,ytShowInfo,youtubeFullsize,youtubeLinkText;
	{text_legend},text;
	{previewImage_legend},addPreviewImage;
	{expert_legend:hide},youtube_template,youtube_modal_template,cssID,space;';

/**
 * Subpalettes
 */
$dc['subpalettes']['addPreviewImage'] = 'posterSRC,size,addPlayButton';


/**
 * Fields
 */
$arrFields = [
    'addPreviewImage'        => [
        'label'     => &$GLOBALS['TL_LANG']['tl_content']['addPreviewImage'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['submitOnChange' => true, 'tl_class' => 'clr'],
        'sql'       => "char(1) NOT NULL default ''",
    ],
    'addPlayButton'          => [
        'label'     => &$GLOBALS['TL_LANG']['tl_content']['addPlayButton'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['tl_class' => 'w50'],
        'sql'       => "char(1) NOT NULL default ''",
    ],
    'videoDuration'          => [
        'label'     => &$GLOBALS['TL_LANG']['tl_content']['videoDuration'],
        'exclude'   => true,
        'search'    => true,
        'sorting'   => true,
        'flag'      => 1,
        'inputType' => 'text',
        'eval'      => ['maxlength' => 255, 'tl_class' => 'w50 clr'],
        'sql'       => "varchar(255) NOT NULL default ''",
    ],
    'ytShowRelated'          => [
        'label'     => &$GLOBALS['TL_LANG']['tl_content']['ytShowRelated'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['tl_class' => 'w50'],
        'sql'       => "char(1) NOT NULL default ''",
    ],
    'ytModestBranding'       => [
        'label'     => &$GLOBALS['TL_LANG']['tl_content']['ytModestBranding'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['tl_class' => 'w50'],
        'sql'       => "char(1) NOT NULL default ''",
    ],
    'ytShowInfo'             => [
        'label'     => &$GLOBALS['TL_LANG']['tl_content']['ytShowInfo'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['tl_class' => 'w50'],
        'sql'       => "char(1) NOT NULL default ''",
    ],
    'youtubeFullsize'        => [
        'label'     => &$GLOBALS['TL_LANG']['tl_content']['youtubeFullsize'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['tl_class' => 'w50'],
        'sql'       => "char(1) NOT NULL default ''",
    ],
    'youtubeLinkText'        => [
        'label'            => &$GLOBALS['TL_LANG']['tl_content']['youtubeLinkText'],
        'exclude'          => true,
        'inputType'        => 'select',
        'default'          => 'huh.youtube.modal.link.default',
        'options_callback' => function (\DataContainer $dc) {
            return \Contao\System::getContainer()->get('huh.utils.choice.message')->getCachedChoices('huh.youtube.modal.link');
        },
        'eval'             => ['maxlength' => 255, 'tl_class' => 'w50'],
        'sql'              => "varchar(255) NOT NULL default ''",
    ],
    'youtube_template'       => [
        'label'            => &$GLOBALS['TL_LANG']['tl_content']['youtube_template'],
        'default'          => 'youtube_default',
        'exclude'          => true,
        'inputType'        => 'select',
        'options_callback' => function (\Contao\DataContainer $dc) {
            return System::getContainer()->get('huh.utils.choice.twig_template')->setContext(['youtube_video_'])->getCachedChoices();
        },
        'eval'             => ['tl_class' => 'w50', 'includeBlankOption' => true],
        'sql'              => "varchar(64) NOT NULL default ''",
    ],
    'youtube_modal_template' => [
        'label'            => &$GLOBALS['TL_LANG']['tl_content']['youtube_modal_template'],
        'default'          => 'youtube_modalvideo_default',
        'exclude'          => true,
        'inputType'        => 'select',
        'options_callback' => function (\Contao\DataContainer $dc) {
            return System::getContainer()->get('huh.utils.choice.twig_template')->setContext(['youtube_modalvideo_'])->getCachedChoices();
        },
        'eval'             => ['tl_class' => 'w50', 'includeBlankOption' => true],
        'sql'              => "varchar(64) NOT NULL default ''",
    ],
];

$dc['fields'] = array_merge($dc['fields'], $arrFields);
