<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YoutubeBundle\Backend;

use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Contao\DataContainer;

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
        $objNews = \NewsModel::findById($this->Input->get('id'));
        $dc = &$GLOBALS['TL_DCA']['tl_news'];
        if (!$objNews->addPreviewImage) {
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
        $news = \Contao\NewsModel::findBy(['addYoutube = 1', 'youtube != ""'], null, ['order' => 'headline']);

        if (null === $news) {
            return $options;
        }

        while ($news->next()) {
            $options[$news->id] = $news->headline.' [ID: '.$news->id.']';
        }

        return $options;
    }
}
