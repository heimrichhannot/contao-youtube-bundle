<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YoutubeBundle\Configuration;

use Contao\CoreBundle\Framework\ContaoFrameworkInterface;

/**
 * Interface YoutubeConfigInterface.
 */
interface YoutubeConfigInterface
{
    /**
     * Get all config data.
     *
     * @return array
     */
    public function getData(): array;

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
     *
     * @return bool
     */
    public function hasVideo(): bool;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return bool
     */
    public function isAddYouTube(): bool;

    /**
     * @return bool
     */
    public function isAutoplay(): bool;

    /**
     * @return string
     */
    public function getYoutube(): string;

    /**
     * @return string
     */
    public function getSize(): string;

    /**
     * @return string
     */
    public function getVideoDuration(): string;

    /**
     * @return bool
     */
    public function isShowRelated(): bool;

    /**
     * @return bool
     */
    public function isModestBranding(): bool;

    /**
     * @return bool
     */
    public function isShowInfo(): bool;

    /**
     * @return bool
     */
    public function isFullSize(): bool;

    /**
     * @return string
     */
    public function getLinkText(): string;

    /**
     * @return bool
     */
    public function isAddPreviewImage(): bool;

    /**
     * @return string
     */
    public function getPreviewImage(): string;

    /**
     * @return bool
     */
    public function isAddPlayButton(): bool;

    /**
     * @return bool
     */
    public function isYoutubePrivacy(): bool;

    /**
     * @return string
     */
    public function getYoutubePrivacyTemplate(): string;

    /**
     * @return ContaoFrameworkInterface
     */
    public function getFramework(): ContaoFrameworkInterface;
}
