<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YoutubeBundle\ContentElement;

use Contao\BackendTemplate;
use Contao\ContentElement;
use Contao\System;
use HeimrichHannot\YoutubeBundle\Configuration\ConfigFactory;

class ContentYouTube extends ContentElement
{
    const TYPE = 'youtube';

    protected $strTemplate = 'ce_youtube';

    /**
     * {@inheritdoc}
     */
    public function generate()
    {
        if (System::getContainer()->get('huh.utils.container')->isBackend()) {
            $this->Template = new BackendTemplate('be_wildcard');
            $this->Template->title = 'YouTube-Video '.$this->youtube;

            return $this->Template->parse();
        }

        return parent::generate();
    }

    /**
     * {@inheritdoc}
     */
    protected function compile()
    {
        System::getContainer()->get('huh.youtube.videocreator')
            ->createVideo(ConfigFactory::CONTEXT_CONTENT_ELEMENT, $this->objModel->row())
            ->addToTemplate($this->Template);
    }
}
