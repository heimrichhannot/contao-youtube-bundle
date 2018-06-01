<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YoutubeBundle\Video;

use Contao\System;

trait YoutubeVideoTemplateDataTrait
{
    /**
     * Get all template data.
     *
     * @return array
     */
//    public function getTemplateData(): array
//    {
//        $data = [];
//
//        $data['addPreviewImage'] = true === $this->getConfig()->isAddPreviewImage() || true === $this->getConfig()->isYoutubePrivacy();
//        $data['playTitle'] = $this->getYouTubeSrc();
//
//        return $data;
//    }

    /**
     * Get the youtube src url.
     */
    public function getSrc(): string
    {
        $strUrl = true === $this->getConfig()->isYoutubePrivacy() ? static::PRIVACY_EMBED_URL : static::DEFAULT_EMBED_URL;
        $strUrl .= $this->getConfig()->getYoutube();

        $queryParams = [];
        $queryParams['rel'] = $this->getConfig()->isShowRelated();
        $queryParams['modestbranding'] = $this->getConfig()->isModestBranding();
        $queryParams['showinfo'] = $this->getConfig()->isShowInfo();

        if ($this->startPlay() || $this->getConfig()->isAutoplay()) {
            $queryParams['autoplay'] = 1;
        }

        return System::getContainer()->get('huh.utils.url')->addQueryString(http_build_query($queryParams), $strUrl);
    }

    /**
     * Add preview image.
     *
     * @return bool
     */
    public function isAddPreviewImage(): bool
    {
        return true === $this->getConfig()->isAddPreviewImage() || true === $this->config->isYoutubePrivacy();
    }

    /**
     * Render the privacy template.
     *
     * @return string
     */
    public function getPrivacy(): string
    {
        if (false === $this->config->isYoutubePrivacy()) {
            return '';
        }

        $data = [];

        return System::getContainer()->get('twig')->render(
            System::getContainer()->get('huh.utils.template')->getTemplate($this->getConfig()->getYoutubePrivacyTemplate()),
            $data
        );
    }
}
