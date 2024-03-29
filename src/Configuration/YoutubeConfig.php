<?php

/*
 * Copyright (c) 2022 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YoutubeBundle\Configuration;

use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Contao\Frontend;
use Contao\PageModel;
use Contao\StringUtil;

/**
 * Class YoutubeConfig.
 */
class YoutubeConfig implements YoutubeConfigInterface
{
    /**
     * @var string
     */
    protected $type = '';

    /**
     * @var bool
     */
    protected $addYouTube = false;

    /**
     * @var bool
     */
    protected $autoplay = false;

    /**
     * @var string
     */
    protected $youtube = '';

    /**
     * @var string
     */
    protected $size = '';

    /**
     * @var string
     */
    protected $videoDuration = '';

    /**
     * @var bool
     */
    protected $showRelated = false;

    /**
     * @var bool
     */
    protected $modestBranding = false;

    /**
     * @var bool
     */
    protected $showInfo = false;

    /**
     * @var bool
     */
    protected $fullSize = false;

    /**
     * @var string
     */
    protected $linkText = '';

    /**
     * @var bool
     */
    protected $addPreviewImage = false;

    /**
     * @var string
     */
    protected $previewImage = '';

    /**
     * @var bool
     */
    protected $addPlayButton = false;

    /**
     * @var bool
     */
    protected $youtubePrivacy = false;

    /**
     * @var string
     */
    protected $template = 'youtube_video_default';

    /**
     * @var string
     */
    protected $privacyTemplate = 'youtube_privacy_default';

    /**
     * @var string
     */
    protected $modalTemplate = 'youtube_modalvideo_default';

    /**
     * @var string
     */
    protected $headline = '';

    /**
     * @var string
     */
    protected $text = '';

    /**
     * Current root page.
     *
     * @var PageModel
     */
    protected $rootPage;

    /**
     * @var ContaoFrameworkInterface
     */
    private $framework;

    /**
     * Constructor.
     */
    public function __construct(ContaoFrameworkInterface $framework, array $config = null)
    {
        $this->framework = $framework;

        if ($config) {
            $this->setData($config);
        }
    }

    /**
     * Set an object property.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function __set($key, $value)
    {
        switch ($key) {
            case 'imgSize':
                $key = 'size';

                break;

            case 'ytShowRelated':
                $key = 'showRelated';

                break;

            case 'ytModestBranding':
                $key = 'modestBranding';

                break;

            case 'ytShowInfo':
                $key = 'showInfo';

                break;

            case 'youtubeFullsize':
                $key = 'fullSize';

                break;

            case 'youtubeLinkText':
                $key = 'linkText';

                break;

            case 'posterSRC':
                $key = 'previewImage';

                break;

            case 'youtube_template':
                $key = 'template';

                break;

            case 'youtube_modal_template':
                $key = 'modalTemplate';

                break;

            case 'youtubePrivacyTemplate':
                $key = 'privacyTemplate';

                break;
        }

        $this->{$key} = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function hasVideo(): bool
    {
        // tl_content type youtube or addYoutube for tl_news must be set
        return ('youtube' === $this->getType() || true === (bool) $this->isAddYouTube()) && !empty($this->getYoutube());
    }

    /**
     * Checks if `$var` can be cast to string, either with `strval($var)` or `(string) $var`.
     * This is the case if one of the following conditions is true.
     */
    private static function canCastToString($var): bool {
        return null === $var || is_scalar($var) || (is_object($var) && method_exists($var, '__toString'));
    }

    /**
     * @param array $data
     * @param mixed $key
     * @param mixed $default
     * @return mixed
     */
    private static function getDataValue(array $data, $key, $default)
    {
        if (array_key_exists($key, $data) && self::canCastToString($data[$key])) {
            return (string) $data[$key];
        }

        if (self::canCastToString($default)) {
            return (string) $default;
        }

        return $default;
    }

    /**
     * {@inheritdoc}
     */
    public function setData(array $data = []): YoutubeConfigInterface
    {
        /* @var Frontend $frontend */
        $frontend = $this->framework->getAdapter(Frontend::class);

        if (null === ($root = $frontend->getRootPageFromUrl())) {
            return $this;
        }

        // array_filter() : do not overwrite empty values

        $filteredRows = array_filter($root->row(), function ($var) {
            /**
             * Checks if the string value of `$var` is truthy.
             * Note: `strval(array())` will return `string(5) "Array"` and is therefore considered true.
             */
            return @strval($var);
        });

        $filteredData = array_filter($data, function ($var) {
            return self::canCastToString($var);
        });

        $mergedData = array_merge($filteredRows, $filteredData);

        foreach ($data as $key => $default) {
            $this->{$key} = self::getDataValue($mergedData, $key, $default);
        }

        $this->rootPage = $root;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function isAddYouTube(): bool
    {
        return $this->addYouTube;
    }

    /**
     * {@inheritdoc}
     */
    public function isAutoplay(): bool
    {
        return $this->autoplay;
    }

    /**
     * {@inheritdoc}
     */
    public function getYoutube(): string
    {
        return $this->youtube;
    }

    /**
     * {@inheritdoc}
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * {@inheritdoc}
     */
    public function getVideoDuration(): string
    {
        return $this->videoDuration;
    }

    /**
     * {@inheritdoc}
     */
    public function isShowRelated(): bool
    {
        return $this->showRelated;
    }

    /**
     * {@inheritdoc}
     */
    public function isModestBranding(): bool
    {
        return $this->modestBranding;
    }

    /**
     * {@inheritdoc}
     */
    public function isShowInfo(): bool
    {
        return $this->showInfo;
    }

    /**
     * {@inheritdoc}
     */
    public function isFullSize(): bool
    {
        return $this->fullSize;
    }

    /**
     * {@inheritdoc}
     */
    public function getLinkText(): string
    {
        return $this->linkText;
    }

    /**
     * {@inheritdoc}
     */
    public function isAddPreviewImage(): bool
    {
        return $this->addPreviewImage;
    }

    /**
     * {@inheritdoc}
     */
    public function getPreviewImage(): string
    {
        return $this->previewImage;
    }

    /**
     * {@inheritdoc}
     */
    public function isAddPlayButton(): bool
    {
        return $this->addPlayButton;
    }

    /**
     * {@inheritdoc}
     */
    public function isYoutubePrivacy(): bool
    {
        return $this->youtubePrivacy;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate(): string
    {
        return $this->template ?: 'youtube_video_default';
    }

    /**
     * {@inheritdoc}
     */
    public function getPrivacyTemplate(): string
    {
        return $this->privacyTemplate ?: 'youtube_privacy_default';
    }

    /**
     * {@inheritdoc}
     */
    public function getModalTemplate(): string
    {
        return $this->modalTemplate ?: 'youtube_modalvideo_default';
    }

    /**
     * {@inheritdoc}
     */
    public function getHeadline(): array
    {
        return StringUtil::deserialize($this->headline, true);
    }

    /**
     * {@inheritdoc}
     */
    public function getText(): string
    {
        return \is_string($this->text) ? $this->text : '';
    }

    /**
     * {@inheritdoc}
     */
    public function getHeadlineText(): string
    {
        $headline = $this->getHeadline();

        if (!empty($headline) && isset($headline['value'])) {
            return $headline['value'];
        }

        return '';
    }

    public function getRootPage(): PageModel
    {
        return $this->rootPage;
    }

    /**
     * {@inheritdoc}
     */
    public function getFramework(): ContaoFrameworkInterface
    {
        return $this->framework;
    }
}
