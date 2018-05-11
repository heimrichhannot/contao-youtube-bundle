<?php
/**
 * Contao Open Source CMS
 * 
 * Copyright (c) 2015 Heimrich & Hannot GmbH
 * @package anwaltverein
 * @author Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\YouTube;


class YouTubeBackend extends \Backend
{

	/**
	 * Return all youtube templates as array
	 * @return array
	 */
	public function getYouTubeTemplates()
	{
		return $this->getTemplateGroup('youtube_');
	}

	/**
	 * Return all youtube privacy templates as array
	 *
	 * @return array
	 */
	public function getPrivacyTemplates()
	{
		return $this->getTemplateGroup('youtubeprivacy_');
	}
}