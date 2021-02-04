<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YoutubeBundle\Backend;

use Contao\CalendarEventsModel;
use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Contao\DataContainer;
use Contao\System;

class Events
{
    /**
     * The contao framework.
     *
     * @var ContaoFrameworkInterface
     */
    private $framework;

    /**
     * Constructor.
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

        if (null === ($event = $this->framework->getAdapter(CalendarEventsModel::class)->findById($id))) {
            return;
        }

        $dc = &$GLOBALS['TL_DCA']['tl_calendar_events'];

        if (!$event->addPreviewImage) {
            $dc['subpalettes']['addYouTube'] =
                str_replace('imgHeader,imgPreview,addPlayButton,', '', $dc['subpalettes']['addYouTube']);
        }
    }
}
