<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YoutubeBundle\Video;

use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use HeimrichHannot\RequestBundle\Component\HttpFoundation\Request;
use HeimrichHannot\UtilsBundle\Classes\ClassUtil;
use HeimrichHannot\UtilsBundle\Template\TemplateUtil;
use HeimrichHannot\YoutubeBundle\Configuration\ConfigFactory;
use Twig_Environment;

class VideoFactory
{
    /**
     * @var ContaoFrameworkInterface
     */
    private $framework;
    /**
     * @var Twig_Environment
     */
    private $twig;
    /**
     * @var Request
     */
    private $request;
    /**
     * @var TemplateUtil
     */
    private $templateUtil;
    /**
     * @var ClassUtil
     */
    private $classUtil;
    /**
     * @var ConfigFactory
     */
    private $configFactory;

    public function __construct(ContaoFrameworkInterface $framework, Twig_Environment $twig, Request $request, TemplateUtil $templateUtil, ClassUtil $classUtil, ConfigFactory $configFactory)
    {
        $this->framework = $framework;
        $this->twig = $twig;
        $this->request = $request;
        $this->templateUtil = $templateUtil;
        $this->classUtil = $classUtil;
        $this->configFactory = $configFactory;
    }

    /**
     * Create a video instance
     * Config is created if content and config is given.
     *
     * @return YoutubeVideoInterface
     */
    public function createVideo(string $context = null, array $configData = null)
    {
        if (!empty($context)) {
            $configData = $this->configFactory->createConfig($context, $configData);
        }

        return new YoutubeVideo($this->framework, $this->twig, $this->request, $this->templateUtil, $this->classUtil, $configData);
    }
}
