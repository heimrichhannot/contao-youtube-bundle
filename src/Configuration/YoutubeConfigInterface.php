<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YoutubeBundle\Configuration;

use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Contao\PageModel;

/**
 * Interface YoutubeConfigInterface.
 */
interface YoutubeConfigInterface
{
    /**
     * Set all config data.
     *
     * @param array $data The whole configuration data
     *
     * @return YoutubeConfigInterface Current instance
     */
    public function setData(array $data): self;

    /**
     * Check that youtube within settings is active (key present or type selector…).
     */
    public function hasVideo(): bool;

    public function getType(): string;

    public function isAddYouTube(): bool;

    public function isAutoplay(): bool;

    public function getYoutube(): string;

    public function getSize(): string;

    public function getVideoDuration(): string;

    public function isShowRelated(): bool;

    public function isModestBranding(): bool;

    public function isShowInfo(): bool;

    public function isFullSize(): bool;

    public function getLinkText(): string;

    public function isAddPreviewImage(): bool;

    public function getPreviewImage(): string;

    public function isAddPlayButton(): bool;

    public function isYoutubePrivacy(): bool;

    public function getRootPage(): ?PageModel;

    public function getTemplate(): string;

    public function getPrivacyTemplate(): string;

    public function getModalTemplate(): string;

    public function getHeadline(): array;

    public function getHeadlineText(): string;

    public function getText(): string;

    public function getFramework(): ContaoFrameworkInterface;
}
