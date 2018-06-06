<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YoutubeBundle\Video;

use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Contao\StringUtil;
use Contao\System;
use Contao\Template;
use HeimrichHannot\YoutubeBundle\Configuration\YoutubeConfigInterface;
use HeimrichHannot\YoutubeBundle\Exception\InvalidVideoConfigException;

class YoutubeVideo implements YoutubeVideoInterface
{
    use YoutubeVideoTemplateDataTrait;

    const PRIVACY_EMBED_URL = '//www.youtube-nocookie.com/embed/';
    const DEFAULT_EMBED_URL = '//www.youtube.com/embed/';

    const VIDEO_IMAGE_URL = 'https://www.googleapis.com/youtube/v3/videos?id=%s&key=%s&fields=items(snippet(thumbnails))&part=snippet';
    const VIDEO_IMAGE_CACHE_DIR = 'files/media/youtube';
    const VIDEO_IMAGE_CACHE_EXPIRE = 604800; // 7 days

    /**
     * Current template data.
     *
     * @var array
     */
    protected $templateData = [];

    /**
     * Youtube config.
     *
     * @var YoutubeConfigInterface
     */
    protected $config;

    /**
     * The contao framework.
     *
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
     * {@inheritdoc}
     */
    public function generate(): string
    {
        if (false === $this->config->hasVideo()) {
            throw new InvalidVideoConfigException('Invalid video configuration, no video data present');
        }

        $template = $this->getConfig()->isFullSize() ? $this->getConfig()->getModalTemplate() : $this->getConfig()->getTemplate();

        return System::getContainer()->get('twig')->render(
            System::getContainer()->get('huh.utils.template')->getTemplate($template),
            $this->getTemplateData()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function addToTemplate(Template $template): void
    {
        $youtube = new \stdClass();
        $youtube->data = $this->getTemplateData();
        $youtube->video = $this->generate();

        $template->setData(array_merge($template->getData(), ['youtube' => $youtube]));
    }

    /**
     * {@inheritdoc}
     */
    public function setConfig(YoutubeConfigInterface $config): YoutubeVideoInterface
    {
        $this->config = $config;

        $this->templateData = System::getContainer()->get('huh.utils.class')->jsonSerialize($this, System::getContainer()->get('huh.utils.class')->jsonSerialize($config));
        $this->templateData['id'] = StringUtil::standardize($config->getYoutube());

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig(): YoutubeConfigInterface
    {
        return $this->config;
    }

    /**
     * {@inheritdoc}
     */
    public function startPlay(): bool
    {
        return $this->getConfig()->isAutoplay() || $this->getConfig()->getYoutube() === System::getContainer()->get('huh.request')->getGet('autoplay');
    }

    /**
     * {@inheritdoc}
     */
    protected function getTemplateData(): array
    {
        return $this->templateData;
    }
}
