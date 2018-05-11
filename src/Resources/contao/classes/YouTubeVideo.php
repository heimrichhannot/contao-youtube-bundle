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

namespace HeimrichHannot\YouTube;

use Haste\Util\Url;
use HeimrichHannot\Haste\Util\Curl;

class YouTubeVideo
{
    protected static $strTemplate = 'youtube_default';

    protected static $strFullsizeTemplate = 'youtube_modal';

    protected static $strPrivacyTemplate = 'youtubeprivacy_default';

    protected static $defaultEmbedSrc = '//www.youtube.com/embed/';

    protected static $privacyEmbedSrc = '//www.youtube-nocookie.com/embed/';

    protected static $strVideoImageUrl = 'https://www.googleapis.com/youtube/v3/videos?id=%s&key=%s&fields=items(snippet(thumbnails))&part=snippet';

    /**
     * Current object instance (do not remove)
     *
     * @var YouTubeVideo
     */
    protected static $objInstance;

    protected $arrData = [];

    protected $arrConfig = [];

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
     * Instantiate a new user object (Factory)
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

    public function addToTemplate($objTemplate)
    {
        $objTemplate->youtubeVideo = $this->generate();
    }

    public function generate($blnIgnoreFullsize = false)
    {
        if (!$this->init() && !$blnIgnoreFullsize) {
            return '';
        }

        // always show preview image when in privacy mode
        $this->addPreviewImage = $this->addPreviewImage || $this->getConfigData('youtubePrivacy');

        $objTemplate =
            new \FrontendTemplate($this->getConfigData('youtube_template') != '' ? $this->getConfigData('youtube_template') : static::$strTemplate);

        // set from item
        $objTemplate->setData($this->getData());
        $objTemplate->playTitle  = $GLOBALS['TL_LANG']['MSC']['youtube']['play'];
        $objTemplate->youtubeSrc = static::getYouTubeSrc();

        $this->addConfigToTemplate($objTemplate);

        // add preview image when in privacy mode, cause we need something to show
        if ($this->addPreviewImage || $this->getConfigData('youtubePrivacy')) {
            $this->addPreviewImageToTemplate($objTemplate);
        }

        if ($this->getConfigData('youtubePrivacy')) {
            $this->addPrivacyToTemplate($objTemplate);
        }

        // fullsize link template
        if ($this->youtubeFullsize && !$blnIgnoreFullsize) {
            $objTemplateFullsize = new \FrontendTemplate(static::$strFullsizeTemplate);
            $objTemplateFullsize->setData($objTemplate->getData());

            $objTemplateFullsize->youtubeVideo = $this->generate(true);
            $objTemplate->fullsizeLink         = $objTemplateFullsize->parse();
        }

        return $objTemplate->parse();
    }

    protected function addPrivacyToTemplate($objTemplate)
    {
        $objTemplate->privacy       = $this->generatePrivacy();
        $objTemplate->addPlayButton = true;
    }

    protected function addConfigToTemplate($objTemplate)
    {
        // add settings
        foreach ($this->getConfig() as $key => $value) {
            $objTemplate->{$key} = $value;
        }
    }

    protected function addPreviewImageToTemplate($objTemplate)
    {
        $singleSRC = '';

        if ($this->posterSRC != '') {
            $objModel = \FilesModel::findByUuid($this->posterSRC);

            if ($objModel !== null) {
                $singleSRC = $objModel->path;
            }
        }

        // add youtube thumbnail
        if ($singleSRC == '') {
            if ($this->skipImageCaching) {
                $objTemplate->skipImageCaching = $this->skipImageCaching;

                list($ytPosterSRC, $strResult, $objTemplate->previewImageUrl) = static::getYouTubeImage($this->youtube);
            } else {
                if (($singleSRC = static::getCachedYouTubePreviewImage()) !== false && file_exists(TL_ROOT . '/' . $singleSRC)) {
                    $arrImage['singleSRC'] = $singleSRC;
                    $arrImage['alt']       = 'youtube-image-' . $this->youtube;

                    if ($this->getConfigData('imgSize') != '' || $this->getConfigData('size')) {
                        $size = deserialize($this->getConfigData('imgSize') ? $this->getConfigData('imgSize') : $this->getConfigData('size'));

                        if ($size[0] > 0 || $size[1] > 0 || is_numeric($size[2])) {
                            $arrImage['size'] = $size;
                        }
                    }

                    \Controller::addImageToTemplate($objTemplate, $arrImage);
                }
            }
        }
    }

    public function getCachedYouTubePreviewImage()
    {
        $strPosterSRC  = $this->youtube . '.jpg';
        $strPosterDir  = 'files/media/youtube/';
        $strPosterPath = $strPosterDir . $strPosterSRC;

        if (!file_exists(TL_ROOT . '/' . $strPosterDir)) {
            new \Folder($strPosterDir);
        }

        $objFile = new \File($strPosterPath);

        // simple file caching
        if (!file_exists(TL_ROOT . '/' . $strPosterPath) || $this->tstamp > $objFile->mtime || $objFile->size == 0) {
            list($ytPosterSRC, $strResult, $strImageUrl) = static::getYouTubeImage($this->youtube);

            if (!$ytPosterSRC || !$strResult || !$strImageUrl) {
                return false;
            }

            $objFile->write($strResult);
            $objFile->close();
        }

        return $objFile->value;
    }

    protected function generatePrivacy()
    {
        $objTemplate = new \FrontendTemplate(
            $this->getConfigData('youtubeprivacy_template') != '' ? $this->getConfigData('youtubeprivacy_template') : static::$strPrivacyTemplate
        );
        $objTemplate->setData($GLOBALS['TL_LANG']['MSC']['youtube']['privacy']);
        $objTemplate->autoLabel = sprintf($objTemplate->autoLabel, \Environment::get('host'));

        return $objTemplate->parse();
    }

    protected function init()
    {
        // tl_content type youtube or addYoutube for tl_news must be set
        $blnCheck = (($this->type == 'youtube' || $this->addYouTube) && $this->youtube != '');

        // autoplay video from autoplay youtube id
        if (\Input::get('autoplay') == $this->youtube || $this->autoplay) {
            $this->autoplay = true;
        }

        return $blnCheck;
    }

    public function getYouTubeSrc()
    {
        if (!$this->init()) {
            return '';
        }

        $strUrl = $this->getConfigData('youtubePrivacy') ? static::$privacyEmbedSrc : static::$defaultEmbedSrc;
        $strUrl .= $this->youtube;


        $queryParams = [];
        $queryParams['rel'] = $this->ytShowRelated ? 1 : 0;
        $queryParams['modestbranding'] = $this->ytModestBranding ? 1 : 0;
        $queryParams['showinfo'] = $this->ytShowInfo ? 1 : 0;

        if ($this->autoplay || $this->getConfigData('autoplay')) {
            $queryParams['autoplay'] = 1;
        }

        return \HeimrichHannot\Haste\Util\Url::addParametersToUri($strUrl, $queryParams);
    }

    public static function getYouTubeImage($strID)
    {
        if (!($strApiKey = \Config::get('youtubeApiKey'))) {
            if (\BackendUser::getInstance()->isAdmin) {
                throw new \Exception('Please specify your API key in the settings if you want to retrieve youtube thumbnails.');
            } else {
                \System::log('Please specify your API key in the settings if you want to retrieve youtube thumbnails.', __METHOD__, TL_ERROR);
            }
        }

        $strResult = Curl::request(sprintf(static::$strVideoImageUrl, $strID, $strApiKey));

        try {

            $objResponse = json_decode($strResult);

            if ($objResponse->error || !is_array($objResponse->items) || empty($objResponse->items)) {
                return [null, null];
            }

            foreach (['maxres', 'standard', 'high', 'medium', 'default'] as $strQuality) {
                if (property_exists($objResponse->items[0]->snippet->thumbnails, $strQuality)) {
                    $varImage = Curl::request($objResponse->items[0]->snippet->thumbnails->{$strQuality}->url);

                    if (!$varImage) {
                        return [null, null];
                    }

                    return [$strID . '_' . $strQuality . '.jpg', $varImage, $objResponse->items[0]->snippet->thumbnails->{$strQuality}->url];
                }
            }
        } catch (\Exception $e) {
            return [null, null];
        }
    }


    public function setData(array $arrData)
    {
        $this->arrData = $arrData;

        return $this;
    }

    public function setConfig(YouTubeSettings $objConfig)
    {
        $this->arrConfig = $objConfig->getData();

        return $this;
    }

    /**
     * Set an object property
     *
     * @param string $strKey
     * @param mixed $varValue
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


    public function getData()
    {
        return $this->arrData;
    }

    public function getConfig()
    {
        return $this->arrConfig;
    }

    public function getConfigData($strKey)
    {
        if (isset($this->arrConfig[$strKey])) {
            return $this->arrConfig[$strKey];
        }
    }
}

