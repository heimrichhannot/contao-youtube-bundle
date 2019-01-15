<?php

/*
 * Copyright (c) 2019 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YoutubeBundle\EventListener;

use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Contao\Date;
use Contao\Module;
use Contao\NewsModel;
use Contao\Template;
use HeimrichHannot\YoutubeBundle\Configuration\ConfigFactory;
use HeimrichHannot\YoutubeBundle\Video\VideoFactory;

class HookListener
{
    /**
     * @var ContaoFrameworkInterface
     */
    private $framework;
    /**
     * @var ConfigFactory
     */
    private $configFactory;
    /**
     * @var VideoFactory
     */
    private $videoFactory;

    /**
     * Constructor.
     *
     * @param ContaoFrameworkInterface $framework
     */
    public function __construct(ContaoFrameworkInterface $framework, VideoFactory $videoFactory, ConfigFactory $configFactory)
    {
        $this->framework = $framework;
        $this->configFactory = $configFactory;
        $this->videoFactory = $videoFactory;
    }

    public function parseNewsArticlesHook(Template $template, array $news, Module $module)
    {
        // set youtube from related youtube video if no youtube video set on current news
        if ($news['relatedYoutubeNews'] > 0 && !$news['addYouTube']) {
            $columns = ['tl_news.id=?'];

            if (isset($arrOptions['ignoreFePreview']) || !BE_USER_LOGGED_IN) {
                $time = Date::floorToMinute();
                $columns[] = "(tl_news.start='' OR tl_news.start<='$time') AND (tl_news.stop='' OR tl_news.stop>'".($time + 60)."') AND tl_news.published='1'";
            }

            /* @var \Contao\NewsModel $newsModel */
            $newsModel = $this->framework->getAdapter(NewsModel::class);

            if (null === ($relatedNews = $newsModel->findBy($columns, [$news['relatedYoutubeNews']]))) {
                return;
            }

            $news['addYouTube'] = 1;
            $template->addYouTube = 1;
            $template->youtube = $relatedNews->youtube;
            $template->autoplay = $relatedNews->autoplay;
            $template->videoDuration = $relatedNews->videoDuration;
            $template->youtubeFullsize = $relatedNews->youtubeFullsize;
            $template->addPreviewImage = $relatedNews->addPreviewImage;
            $template->posterSRC = $relatedNews->posterSRC;
            $template->addPlayButton = $relatedNews->addPlayButton;
        }

        if (!$news['addYouTube'] || !$news['youtube']) {
            return;
        }

        $data = $module->getModel()->row();

        $data['addYouTube'] = $news['addYouTube'];
        $data['youtube'] = $news['youtube'];
        $data['autoplay'] = $news['autoplay'];
        $data['videoDuration'] = $news['videoDuration'];
        $data['youtubeFullsize'] = $news['youtubeFullsize'];
        $data['addPreviewImage'] = $news['addPreviewImage'];
        $data['posterSRC'] = $news['posterSRC'];
        $data['addPlayButton'] = $news['addPlayButton'];

        $this->videoFactory->createVideo(ConfigFactory::CONTEXT_FRONTEND_MODULE, $data)
            ->addToTemplate($template);
    }
}
