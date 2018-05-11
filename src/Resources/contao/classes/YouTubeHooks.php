<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2015 Heimrich & Hannot GmbH
 * @package anwaltverein
 * @author Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\YouTube;


class YouTubeHooks extends \Controller
{

    public function parseNewsArticlesHook($objTemplate, $arrNews, $objModule)
    {
        // set youtube from related youtube video if no youtube video set on current news
        if ($arrNews['relatedYoutubeNews'] > 0 && !$arrNews['addYouTube']) {

            $columns = ["tl_news.id=?"];

            if (isset($arrOptions['ignoreFePreview']) || !BE_USER_LOGGED_IN) {
                $time      = \Date::floorToMinute();
                $columns[] = "(tl_news.start='' OR tl_news.start<='$time') AND (tl_news.stop='' OR tl_news.stop>'" . ($time + 60) . "') AND tl_news.published='1'";
            }

            if (($relatedNews = \Contao\NewsModel::findBy($columns, [$arrNews['relatedYoutubeNews']])) == null) {
                return;
            }

            $arrNews['addYouTube']        = 1;
            $objTemplate->addYouTube      = 1;
            $objTemplate->youtube         = $relatedNews->youtube;
            $objTemplate->autoplay        = $relatedNews->autoplay;
            $objTemplate->videoDuration   = $relatedNews->videoDuration;
            $objTemplate->youtubeFullsize = $relatedNews->youtubeFullsize;
            $objTemplate->addPreviewImage = $relatedNews->addPreviewImage;
            $objTemplate->posterSRC       = $relatedNews->posterSRC;
            $objTemplate->addPlayButton   = $relatedNews->addPlayButton;
        }

        if (!$arrNews['addYouTube']) {
            return;
        }

        $objConfig = YouTubeSettings::getInstance()->setModule($objModule->getModel());

        YouTubeVideo::getInstance()->setData($objTemplate->getData())->setConfig($objConfig)->addToTemplate($objTemplate);
    }

}