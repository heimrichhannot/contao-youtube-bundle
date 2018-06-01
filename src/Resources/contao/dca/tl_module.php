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

$dc = &$GLOBALS['TL_DCA']['tl_module'];

/**
 * Selectors
 */

/**
 * Palettes
 */
$dc['palettes']['newslist']    = str_replace('imgSize', 'imgSize;{youtube_legend},youtube_template', $dc['palettes']['newslist']);
$dc['palettes']['newsarchive'] = str_replace('imgSize', 'imgSize;{youtube_legend},youtube_template', $dc['palettes']['newsarchive']);
$dc['palettes']['newsreader']  = str_replace('imgSize', 'imgSize;{youtube_legend},youtube_template,autoplay', $dc['palettes']['newsreader']);


/**
 * Fields
 */
$arrFields = [
    'autoplay' => [
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['autoplay'],
        'exclude'                 => true,
        'inputType'               => 'checkbox',
        'eval'                    => ['tl_class' =>'w50 m12'],
        'sql'                     => "char(1) NOT NULL default ''"],
    'youtube_template' => [
        'label'            => &$GLOBALS['TL_LANG']['tl_module']['youtube_template'],
        'default'          => 'youtube_default',
        'exclude'          => true,
        'inputType'        => 'select',
        'options_callback' => function (\Contao\DataContainer $dc) {
            return System::getContainer()->get('huh.utils.choice.twig_template')->setContext(['youtube_video_'])->getCachedChoices();
        },
        'eval'             => ['tl_class' => 'w50'],
        'sql'              => "varchar(64) NOT NULL default ''",]];

$dc['fields'] = array_merge($dc['fields'], $arrFields);