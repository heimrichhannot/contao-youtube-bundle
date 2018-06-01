<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YoutubeBundle\Video;

use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Contao\System;
use Contao\Template;
use HeimrichHannot\YoutubeBundle\Configuration\YoutubeConfigInterface;
use HeimrichHannot\YoutubeBundle\Exception\InvalidVideoConfigException;

class YoutubeVideo implements YoutubeVideoInterface
{
    use YoutubeVideoTemplateDataTrait;

    const PRIVACY_EMBED_URL = '//www.youtube-nocookie.com/embed/';

    const DEFAULT_EMBED_URL = '//www.youtube.com/embed/';

    /**
     * Youtube twig template name.
     *
     * @var string
     */
    protected $template = 'youtube_video_default';

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

        return System::getContainer()->get('twig')->render(
            System::getContainer()->get('huh.utils.template')->getTemplate($this->getTemplate()),
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
    public function setTemplate(string $template): YoutubeVideoInterface
    {
        $this->template = $template;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * {@inheritdoc}
     */
    public function setConfig(YoutubeConfigInterface $config): YoutubeVideoInterface
    {
        $this->config = $config;

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
        return System::getContainer()->get('huh.utils.class')->jsonSerialize($this, System::getContainer()->get('huh.utils.class')->jsonSerialize($this->getConfig()));
    }
}
