<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2015 Heimrich & Hannot GmbH
 * @package youtube
 * @author Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\YouTube;


use Contao\System;

class ContentYouTube extends \ContentElement
{

    protected $strTemplate = 'ce_youtube';

    /**
     * @inheritdoc
     */
    public function generate()
    {
        if (System::getContainer()->get('huh.utils.container')->isBackend()) {
            $this->Template        = new \BackendTemplate('be_wildcard');
            $this->Template->title = 'YouTube-Video ' . $this->youtube;
            return $this->Template->parse();
        }

        return parent::generate();
    }

    /**
     * @inheritdoc
     */
    protected function compile()
    {
        System::getContainer()->get('huh.youtube.video')->setConfig(
            System::getContainer()->get('huh.youtube.config')->setData($this->objModel->row())
        )->addToTemplate($this->Template);
    }
}
