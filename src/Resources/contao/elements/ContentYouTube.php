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


class ContentYouTube extends \ContentElement
{

	protected $strTemplate = 'ce_youtube';

	protected static $iFrameIdCounter = 0;

	protected function compile()
	{
		if (TL_MODE == 'FE')
		{
			$this->Template = new \FrontendTemplate($this->strTemplate);
			$this->Template->setData($this->arrData);

			$objConfig = YouTubeSettings::getInstance()->setModule($this->objModel);
			
			YouTubeVideo::getInstance()->setData($this->arrData)->setConfig($objConfig)->addToTemplate($this->Template);
		}
		else
		{
			$this->strTemplate     = 'be_wildcard';
			$this->Template        = new \BackendTemplate($this->strTemplate);
			$this->Template->title = 'YouTube-Video ' . $this->youtube;
		}
	}
}
