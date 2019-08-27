<?php

/*
 * Copyright (c) 2019 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YouTubeBundle\Twig;

use Contao\FrontendTemplate;
use Contao\System;
use HeimrichHannot\YoutubeBundle\Configuration\ConfigFactory;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class YouTubeExtension extends AbstractExtension implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * Get list of twig filters.
     *
     * @return array|\Twig_SimpleFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('youtube', [$this, 'getYouTubeVideo']),
        ];
    }

    public function getYouTubeVideo($youtube, array $data = [], string $templateName = '@HeimrichHannotContaoYoutube/youtube_video/youtube_video_default.html.twig'): string
    {
        $template = new FrontendTemplate();

        $data['youtube'] = $youtube;

        $template->setData($data);

        System::getContainer()->get('huh.youtube.videocreator')->createVideo(ConfigFactory::CONTEXT_FRONTEND_MODULE, $data)
            ->addToTemplate($template);

        return $template->youTubeVideo;
    }
}
