<?php

$arrDca = &$GLOBALS['TL_DCA']['tl_settings'];

/**
 * Palettes
 */
$arrDca['palettes']['default'] .= ';{youtube_legend},youtubeApiKey,youtubeSkipImageCaching;';

/**
 * Fields
 */
$arrFields = [
    'youtubeApiKey'           => [
        'label'     => &$GLOBALS['TL_LANG']['tl_settings']['youtubeApiKey'],
        'exclude'   => true,
        'inputType' => 'text',
        'eval'      => ['maxlength' => 255, 'tl_class' => 'w50'],
        'sql'       => "varchar(255) NOT NULL default ''",
    ],
    'youtubeSkipImageCaching' => [
        'label'     => &$GLOBALS['TL_LANG']['tl_settings']['youtubeSkipImageCaching'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['tl_class' => 'clr'],
        'sql'       => "char(1) NOT NULL default ''",
    ],
];

$arrDca['fields'] = array_merge($arrDca['fields'], $arrFields);