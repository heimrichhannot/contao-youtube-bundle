<?php
/**
 * Contao Open Source CMS
 * 
 * Copyright (c) 2015 Heimrich & Hannot GmbH
 * @package youtube
 * @author Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\YouTube;


class UpgradeHandler
{

	public static function run()
	{
		// CTE type responsive_youtube_video changed to youtube
		\Database::getInstance()->prepare("UPDATE tl_content SET type = ? WHERE type = ? ")->execute('youtube', 'responsive_youtube_video');

		\Database::getInstance()->prepare("ALTER TABLE tl_news CHANGE addResponsiveYouTubeVideo addYouTube char(1) NOT NULL default ''")->execute();

		\Database::getInstance()->prepare("UPDATE tl_module SET youtube_template = ? WHERE youtube_template = '' ")->execute('youtube_default');

		return;
	}
}