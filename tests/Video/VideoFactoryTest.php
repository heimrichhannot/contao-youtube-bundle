<?php

/*
 * Copyright (c) 2019 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YoutubeBundle\Test\Video;

use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\TestCase\ContaoTestCase;
use HeimrichHannot\RequestBundle\Component\HttpFoundation\Request;
use HeimrichHannot\UtilsBundle\Classes\ClassUtil;
use HeimrichHannot\UtilsBundle\Template\TemplateUtil;
use HeimrichHannot\YoutubeBundle\Configuration\ConfigFactory;
use HeimrichHannot\YoutubeBundle\Video\VideoFactory;
use Symfony\Component\HttpFoundation\RequestStack;

class VideoFactoryTest extends ContaoTestCase
{
    public function SKIPtestCreateVideo()
    {
        $framework = $this->mockContaoFramework();
        /** @var \Twig_Environment $twig */
        $twig = $this->createMock(\Twig_Environment::class);
        $requestStack = new RequestStack();
        $request = new Request($framework, $requestStack, $this->createMock(ScopeMatcher::class));
        $templateUtil = $this->createMock(TemplateUtil::class);
        $classUtil = $this->createMock(ClassUtil::class);
        $configFactory = $this->createMock(ConfigFactory::class);
        $videoFactory = new VideoFactory($framework, $twig, $request, $templateUtil, $classUtil, $configFactory);
    }
}
