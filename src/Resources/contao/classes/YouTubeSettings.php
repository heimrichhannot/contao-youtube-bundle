<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2016 Heimrich & Hannot GmbH
 *
 * @package youtube
 * @author  Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\YouTube;


class YouTubeSettings
{
	/**
	 * Current object instance (do not remove)
	 *
	 * @var object
	 */
	protected static $objInstance;

	/**
	 * Config prefixes that can be extracted globally
	 * @var array
	 */
	protected static $arrayKeyPrefixes = ['youtube', 'size', 'imgSize', 'autoplay'];

	protected $arrData = [];

	protected function __construct()
	{
	}

	/**
	 * Prevent cloning of the object (Singleton)
	 */
	final public function __clone()
	{
	}

	/**
	 * Instantiate a object (Factory)
	 *
	 * @return static The object instance
	 */
	public static function getInstance()
	{
		if (static::$objInstance === null) {
			static::$objInstance = new static();
		}

		return static::$objInstance;
	}

	/**
	 * Get all youtube setting, considering root page and content element & module config
	 *
	 * @return array the settings
	 */
	public function getData()
	{
		$arrData = [];

		$objRoot = \Frontend::getRootPageFromUrl();

		if($objRoot === null)
		{
			return $arrData;
		}

		if(!is_array($this->arrData))
		{
			$this->arrData = [];
		}
		
		$arrRootPageData = \HeimrichHannot\Haste\Util\Arrays::filterByPrefixes($objRoot->row(), self::$arrayKeyPrefixes);

		// array_filter() : do not overwrite empty values
		$arrData = array_merge(array_filter($arrRootPageData, 'strval'), array_filter($this->arrData, 'strval'));
		
		return $arrData;
	}


	public function setModule(\Model $objModule)
	{
		$arrData = \HeimrichHannot\Haste\Util\Arrays::filterByPrefixes($objModule->row(), self::$arrayKeyPrefixes);

		$this->arrData = is_array($arrData) ? $arrData : $this->arrData;

		return $this;
	}

	/**
	 * Set an object property
	 *
	 * @param string $strKey
	 * @param mixed  $varValue
	 */
	public function __set($strKey, $varValue)
	{
		$this->arrData[$strKey] = $varValue;
	}


	/**
	 * Return an object property
	 *
	 * @param string $strKey
	 *
	 * @return mixed
	 */
	public function __get($strKey)
	{
		if (isset($this->arrData[$strKey])) {
			return $this->arrData[$strKey];
		}
	}


	/**
	 * Check whether a property is set
	 *
	 * @param string $strKey
	 *
	 * @return boolean
	 */
	public function __isset($strKey)
	{
		return isset($this->arrData[$strKey]);
	}
}