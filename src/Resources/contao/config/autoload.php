<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(
    [
	'HeimrichHannot',]
);


/**
 * Register the classes
 */
ClassLoader::addClasses(
    [
	// Classes
	'HeimrichHannot\YouTube\UpgradeHandler'  => 'system/modules/youtube/classes/UpgradeHandler.php',
	'HeimrichHannot\YouTube\YouTubeVideo'    => 'system/modules/youtube/classes/YouTubeVideo.php',
	'HeimrichHannot\YouTube\YouTubeBackend'  => 'system/modules/youtube/classes/YouTubeBackend.php',
	'HeimrichHannot\YouTube\YouTubeSettings' => 'system/modules/youtube/classes/YouTubeSettings.php',
	'HeimrichHannot\YouTube\YouTubeHooks'    => 'system/modules/youtube/classes/YouTubeHooks.php',

	// Elements
	'HeimrichHannot\YouTube\ContentYouTube'  => 'system/modules/youtube/elements/ContentYouTube.php',]
);


/**
 * Register the templates
 */
TemplateLoader::addFiles(
    [
	'youtubeprivacy_default' => 'system/modules/youtube/templates/privacy',
	'ce_youtube'             => 'system/modules/youtube/templates/elements',
	'youtube_player'         => 'system/modules/youtube/templates/youtube',
	'youtube_image'          => 'system/modules/youtube/templates/youtube',
	'youtube_modal_colorbox' => 'system/modules/youtube/templates/youtube',
	'youtube_modal'          => 'system/modules/youtube/templates/youtube',
	'youtube_default'        => 'system/modules/youtube/templates/youtube',]
);
