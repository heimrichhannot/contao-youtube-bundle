<?php

/*
 * Copyright (c) 2019 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YoutubeBundle\Video;

use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Contao\StringUtil;
use Contao\Template;
use HeimrichHannot\RequestBundle\Component\HttpFoundation\Request;
use HeimrichHannot\UtilsBundle\Classes\ClassUtil;
use HeimrichHannot\UtilsBundle\Template\TemplateUtil;
use HeimrichHannot\YoutubeBundle\Configuration\YoutubeConfigInterface;
use HeimrichHannot\YoutubeBundle\Exception\InvalidVideoConfigException;
use Twig_Environment;

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
     * @var Twig_Environment
     */
    private $twig;
    /**
     * @var TemplateUtil
     */
    private $templateUtil;
    /**
     * @var ClassUtil
     */
    private $classUtil;
    /**
     * @var Request
     */
    private $request;

    /**
     * Constructor.
     *
     * @param ContaoFrameworkInterface    $framework
     * @param Twig_Environment            $twig
     * @param Request                     $request
     * @param TemplateUtil                $templateUtil
     * @param ClassUtil                   $classUtil
     * @param YoutubeConfigInterface|null $config
     */
    public function __construct(ContaoFrameworkInterface $framework, Twig_Environment $twig, Request $request, TemplateUtil $templateUtil, ClassUtil $classUtil, YoutubeConfigInterface $config = null)
    {
        $this->framework = $framework;
        $this->twig = $twig;
        $this->templateUtil = $templateUtil;
        $this->classUtil = $classUtil;
        $this->request = $request;

        if ($config) {
            $this->setConfig($config);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function generate(): string
    {
        if (false === $this->getConfig()->hasVideo()) {
            throw new InvalidVideoConfigException('Invalid video configuration, no video data present');
        }

        $template = $this->getConfig()->isFullSize() ? $this->getConfig()->getModalTemplate() : $this->getConfig()->getTemplate();

        return $this->twig->render(
            $this->templateUtil->getTemplate($template),
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

        $this->templateData = $this->classUtil->jsonSerialize($this, $this->classUtil->jsonSerialize($config));
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
        return $this->getConfig()->isAutoplay() || $this->getConfig()->getYoutube() === $this->request->getGet('autoplay');
    }

    /**
     * {@inheritdoc}
     */
    protected function getTemplateData(): array
    {
        return $this->templateData;
    }
}
