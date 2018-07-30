<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YoutubeBundle\Backend;

use Contao\ContentModel;
use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Contao\DataContainer;

class Content
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

    public function modifyDca(DataContainer $dc)
    {
        /**
         * @var ContentModel
         */
        $content = $this->framework->getAdapter(ContentModel::class);

        if (null === ($content = $content->findByPK($dc->id)) || 'youtube' !== $content->type) {
            return;
        }

        $GLOBALS['TL_DCA']['tl_content']['fields']['text']['eval']['mandatory'] = false;
    }
}
