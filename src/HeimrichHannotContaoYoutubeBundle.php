<?php

/*
 * Copyright (c) 2019 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YoutubeBundle;

use HeimrichHannot\YoutubeBundle\DependencyInjection\HeimrichHannotContaoYoutubeExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HeimrichHannotContaoYoutubeBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new HeimrichHannotContaoYoutubeExtension();
    }
}
