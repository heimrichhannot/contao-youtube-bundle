<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YoutubeBundle\Video;

use Contao\Template;
use HeimrichHannot\YoutubeBundle\Configuration\YoutubeConfigInterface;
use HeimrichHannot\YoutubeBundle\Exception\InvalidVideoConfigException;

interface YoutubeVideoInterface
{
    /**
     * Generate the youtube player.
     *
     * @throws InvalidVideoConfigException
     *
     * @return mixed
     */
    public function generate(): string;

    /**
     * Add youtube to given template.
     *
     * @param Template $template
     */
    public function addToTemplate(Template $template): void;

    /**
     * Get all template data.
     *
     * @return array
     */
    public function getTemplateData(): array;

    /**
     * Set current template name.
     *
     * @param string $template
     *
     * @return YoutubeVideoInterface
     */
    public function setTemplate(string $template): self;

    /**
     * Get current template name.
     *
     * @return string
     */
    public function getTemplate(): string;

    /**
     * Set current config.
     *
     * @return YoutubeVideoInterface
     */
    public function setConfig(YoutubeConfigInterface $config): self;

    /**
     * Get current config.
     *
     * @return YoutubeConfigInterface
     */
    public function getConfig(): YoutubeConfigInterface;

    /**
     * Check if current video should start by checking request params for example.
     *
     * @return bool
     */
    public function startPlay(): bool;
}
