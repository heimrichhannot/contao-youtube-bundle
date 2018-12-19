<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YoutubeBundle\Backend;

use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Contao\DataContainer;
use Contao\NewsModel;
use Contao\System;

class News
{
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
     * Modify the palette according to the checkboxes selected.
     *
     * @param mixed
     * @param DataContainer
     *
     * @return mixed
     */
    public function modifyPalettes()
    {
        if (!($id = System::getContainer()->get('huh.request')->getGet('id'))) {
            return;
        }

        if (null === ($news = $this->framework->getAdapter(NewsModel::class)->findById($id))) {
            return;
        }

        $dc = &$GLOBALS['TL_DCA']['tl_news'];

        if (!$news->addPreviewImage) {
            $dc['subpalettes']['addYouTube'] =
                str_replace('imgHeader,imgPreview,addPlayButton,', '', $dc['subpalettes']['addYouTube']);
        }
    }

    /**
     * Get a list of related news that have a youtube video.
     *
     * @param \Contao\DataContainer $dc
     *
     * @return array List of related youtube news
     */
    public function getRelatedYoutubeNews(\Contao\DataContainer $dc)
    {
        $options = [];

        if (null === ($news = $this->framework->getAdapter(NewsModel::class)->findBy(['addYoutube = 1', 'youtube != ""'], null, ['order' => 'headline']))) {
            return $options;
        }

        while ($news->next()) {
            $options[$news->id] = $news->headline.' [ID: '.$news->id.']';
        }

        return $options;
    }
}
