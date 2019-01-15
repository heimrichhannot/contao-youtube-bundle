<?php
$dc = &$GLOBALS['TL_DCA']['tl_calendar_events'];

\Controller::loadDataContainer('tl_content');

/**
 * Palettes
 */
$dc['palettes']['default']        = str_replace('{image_legend}', '{youtube_legend},addYouTube;{image_legend}', $dc['palettes']['default']);
$dc['subpalettes']['addYouTube']  =
    'youtube,autoplay,videoDuration,youtubeFullsize,youtubeLinkText,addPreviewImage,posterSRC,addPlayButton';
$dc['palettes']['__selector__'][] = 'addYouTube';

/**
 * Callbacks
 */

$dc['config']['onload_callback'][] = ['huh.youtube.backend.events', 'modifyPalettes'];

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
    'youtube'            => &$GLOBALS['TL_DCA']['tl_content']['fields']['youtube'],
    'autoplay'           => &$GLOBALS['TL_DCA']['tl_content']['fields']['autoplay'],
    'addPreviewImage'    => &$GLOBALS['TL_DCA']['tl_content']['fields']['addPreviewImage'],
    'posterSRC'          => &$GLOBALS['TL_DCA']['tl_content']['fields']['posterSRC'],
    'youtubeFullsize'    => &$GLOBALS['TL_DCA']['tl_content']['fields']['youtubeFullsize'],
    'youtubeLinkText'    => &$GLOBALS['TL_DCA']['tl_content']['fields']['youtubeLinkText'],
    'videoDuration'      => &$GLOBALS['TL_DCA']['tl_content']['fields']['videoDuration'],
    'addPlayButton'      => &$GLOBALS['TL_DCA']['tl_content']['fields']['addPlayButton']
];

$dc['fields'] = array_merge($dc['fields'], $arrFields);

$dc['fields']['posterSRC']['eval']['tl_class'] = 'clr';