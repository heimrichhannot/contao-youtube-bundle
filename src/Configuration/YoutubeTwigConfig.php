<?php

/*
 * Copyright (c) 2019 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YoutubeBundle\Configuration;

class YoutubeTwigConfig extends YoutubeConfig
{
    /**
     * @var string
     */
    protected $template = '@HeimrichHannotContaoYoutube/youtube_video/youtube_video_default.html.twig';

    /**
     * @var string
     */
    protected $privacyTemplate = '@HeimrichHannotContaoYoutube/youtube_privacy/youtube_privacy_default.html.twig';

    /**
     * @var string
     */
    protected $modalTemplate = '@HeimrichHannotContaoYoutube/youtube_modalvideo/youtube_modalvideo_default.html.twig';
}
