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

/**
 * Content elements
 */
$GLOBALS['TL_CTE']['media']['youtube'] = 'HeimrichHannot\YoutubeBundle\ContentElement\ContentYouTube';

/**
 * Assets
 */
if (System::getContainer()->get('huh.utils.container')->isFrontend()) {
    $GLOBALS['TL_CSS']['alertifyjs']            = 'assets/alertifyjs/alertifyjs/css/alertify.min.css|static';
    $GLOBALS['TL_CSS']['contao-youtube-bundle'] = 'bundles/heimrichhannotcontaoyoutube/css/contao-youtube-bundle.min.css|static';

    $GLOBALS['TL_JAVASCRIPT']['alertifyjs']            = 'assets/alertifyjs/alertifyjs/alertify.min.js|static';
    $GLOBALS['TL_JAVASCRIPT']['contao-youtube-bundle'] = 'bundles/heimrichhannotcontaoyoutube/js/contao-youtube-bundle.js|static';
}


/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['parseArticles'][] = ['huh.youtube.listener.hooks', 'parseNewsArticlesHook'];