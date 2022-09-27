<?php

/*
 * Copyright (c) 2022 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

if (class_exists(Contao\CalendarBundle\ContaoCalendarBundle::class)) {
    $dc = &$GLOBALS['TL_DCA']['tl_calendar_events'];

    Controller::loadDataContainer('tl_content');

    /*
     * Palettes
     */
    $dc['palettes']['__selector__'][] = 'addYouTube';
    $dc['palettes']['__selector__'][] = 'addPreviewImage';
    $dc['palettes']['default'] = str_replace('{image_legend}', '{youtube_legend},addYouTube;{image_legend}', $dc['palettes']['default']);

    /*
     * Subpalettes
     */
    $dc['subpalettes']['addYouTube'] = 'youtube,autoplay,videoDuration,youtubeFullsize,youtubeLinkText,addPreviewImage,addPlayButton';
    $dc['subpalettes']['addPreviewImage'] = 'posterSRC';

    /*
     * Callbacks
     */

    $dc['config']['onload_callback'][] = ['huh.youtube.backend.events', 'modifyPalettes'];

    /**
     * Fields.
     */
    $arrFields = [
        'addYouTube' => [
            'label' => &$GLOBALS['TL_LANG']['tl_content']['addYouTube'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => ['submitOnChange' => true],
            'sql' => "char(1) NOT NULL default ''",
        ],
        'youtube' => [
            'label' => &$GLOBALS['TL_LANG']['tl_content']['youtube'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'decodeEntities' => true, 'tl_class' => 'w50'],
            'save_callback' => [
                ['tl_content', 'extractYouTubeId'],
            ],
            'sql' => "varchar(16) NOT NULL default ''",
        ],
        'autoplay' => [
            'label' => &$GLOBALS['TL_LANG']['tl_content']['autoplay'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => ['tl_class' => 'w50 m12'],
            'sql' => "char(1) NOT NULL default ''",
        ],
        'addPreviewImage' => &$GLOBALS['TL_DCA']['tl_content']['fields']['addPreviewImage'],
        'posterSRC' => [
            'label' => &$GLOBALS['TL_LANG']['tl_content']['posterSRC'],
            'exclude' => true,
            'inputType' => 'fileTree',
            'eval' => ['filesOnly' => true, 'fieldType' => 'radio'],
            'sql' => 'binary(16) NULL',
        ],
        'youtubeFullsize' => &$GLOBALS['TL_DCA']['tl_content']['fields']['youtubeFullsize'],
        'youtubeLinkText' => &$GLOBALS['TL_DCA']['tl_content']['fields']['youtubeLinkText'],
        'videoDuration' => &$GLOBALS['TL_DCA']['tl_content']['fields']['videoDuration'],
        'addPlayButton' => &$GLOBALS['TL_DCA']['tl_content']['fields']['addPlayButton'],
    ];

    $dc['fields'] = array_merge($dc['fields'], $arrFields);

    $dc['fields']['posterSRC']['eval']['tl_class'] = 'clr';
}
