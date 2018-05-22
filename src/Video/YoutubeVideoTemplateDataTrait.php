<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YoutubeBundle\Video;

trait YoutubeVideoTemplateDataTrait
{
    /**
     * Get all template data.
     *
     * @return array
     */
    public function getTemplateData(): array
    {
        $data = [];

        $data['addPreviewImage'] = true === $this->getConfig()->addPreviewImage || true === $this->getConfig()->youtubePrivacy;
        $data['playTitle'] = $this->getYouTubeSrc();

        return $data;
    }

    /**
     * Get the youtube src url.
     */
    public function getYouTubeSrc(): string
    {
        $strUrl = true === $this->getConfig()->youtubePrivacy ? static::PRIVACY_EMBED_URL : static::DEFAULT_EMBED_URL;
        $strUrl .= $this->getConfig()->youtube;

        $queryParams = [];
        $queryParams['rel'] = $this->ytShowRelated ? 1 : 0;
        $queryParams['modestbranding'] = $this->ytModestBranding ? 1 : 0;
        $queryParams['showinfo'] = $this->ytShowInfo ? 1 : 0;

        if ($this->autoplay || $this->getConfigData('autoplay')) {
            $queryParams['autoplay'] = 1;
        }

        return \HeimrichHannot\Haste\Util\Url::addParametersToUri($strUrl, $queryParams);

        return $strUrl;
    }
}
