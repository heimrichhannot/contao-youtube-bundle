<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YoutubeBundle\Configuration;

use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Contao\Frontend;

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
    protected $youtubePrivacyTemplate = '';

    /**
     * Current config data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * @var ContaoFrameworkInterface
     */
    private $framework;

    /**
     * Constructor.
     *
     * @param ContaoFrameworkInterface $framework
     */
    public function __construct(ContaoFrameworkInterface $framework)
    {
        $this->framework = $framework;
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
                $key = 'ytShowInfo';
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
        $data = array_merge(array_filter($root->row(), 'strval'), array_filter($data, 'strval'));

        foreach ($data as $key => $default) {
            $this->{$key} = $data[$key] ?? $default;
        }

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
    public function getYoutubePrivacyTemplate(): string
    {
        return $this->youtubePrivacyTemplate;
    }

    /**
     * {@inheritdoc}
     */
    public function getFramework(): ContaoFrameworkInterface
    {
        return $this->framework;
    }
}
