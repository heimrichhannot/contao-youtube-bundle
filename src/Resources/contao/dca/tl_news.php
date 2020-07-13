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

$dc = &$GLOBALS['TL_DCA']['tl_news'];

\Controller::loadDataContainer('tl_content');

/**
 * Palettes
 */
$dc['palettes']['default']        = str_replace('{image_legend}', '{youtube_legend},addYouTube,relatedYoutubeNews;{image_legend}', $dc['palettes']['default']);
$dc['subpalettes']['addYouTube']  =
    'youtube,autoplay,videoDuration,youtubeFullsize,youtubeLinkText,addPreviewImage,posterSRC,addPlayButton';
$dc['palettes']['__selector__'][] = 'addYouTube';

/**
 * Callbacks
 */

$dc['config']['onload_callback'][] = ['huh.youtube.backend.news', 'modifyPalettes'];

/**
 * Fields
 */
$arrFields = [
    'addYouTube'         => [
        'label'     => &$GLOBALS['TL_LANG']['tl_content']['addYouTube'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['submitOnChange' => true],
        'sql'       => "char(1) NOT NULL default ''"
    ],
    'youtube' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_content']['youtube'],
        'exclude'                 => true,
        'search'                  => true,
        'inputType'               => 'text',
        'eval'                    => array('mandatory'=>true, 'decodeEntities'=>true, 'tl_class'=>'w50'),
        'save_callback' => array
        (
            array('tl_content', 'extractYouTubeId')
        ),
        'sql'                     => "varchar(16) NOT NULL default ''"
    ),
    'autoplay' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_content']['autoplay'],
        'exclude'                 => true,
        'inputType'               => 'checkbox',
        'eval'                    => array('tl_class'=>'w50 m12'),
        'sql'                     => "char(1) NOT NULL default ''"
    ),
    'addPreviewImage'    => &$GLOBALS['TL_DCA']['tl_content']['fields']['addPreviewImage'],
    'posterSRC' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_content']['posterSRC'],
        'exclude'                 => true,
        'inputType'               => 'fileTree',
        'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio'),
        'sql'                     => "binary(16) NULL"
    ),
    'youtubeFullsize'    => &$GLOBALS['TL_DCA']['tl_content']['fields']['youtubeFullsize'],
    'youtubeLinkText'    => &$GLOBALS['TL_DCA']['tl_content']['fields']['youtubeLinkText'],
    'videoDuration'      => &$GLOBALS['TL_DCA']['tl_content']['fields']['videoDuration'],
    'addPlayButton'      => &$GLOBALS['TL_DCA']['tl_content']['fields']['addPlayButton'],
    'relatedYoutubeNews' => [
        'label'            => &$GLOBALS['TL_LANG']['tl_news']['relatedYoutubeNews'],
        'exclude'          => true,
        'inputType'        => 'tagsinput',
        'options_callback' => ['huh.youtube.backend.news', 'getRelatedYoutubeNews'],
        'sql'              => "varchar(32) NOT NULL default ''",
        'eval'             => [
            'placeholder' => &$GLOBALS['TL_LANG']['tl_news']['placeholder']['relatedYoutubeNews'],
        ],
    ],
];

$dc['fields'] = array_merge($dc['fields'], $arrFields);

$dc['fields']['posterSRC']['eval']['tl_class'] = 'clr';