<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2015 Heimrich & Hannot GmbH
 * @package youtube
 * @author Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


if(class_exists('\\HeimrichHannot\\Youtube\\UpgradeHandler'))
{
	\HeimrichHannot\Youtube\UpgradeHandler::run();
}