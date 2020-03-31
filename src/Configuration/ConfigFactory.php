<?php

/*
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YoutubeBundle\Configuration;

use Contao\CoreBundle\Framework\ContaoFrameworkInterface;

class ConfigFactory
{
    const CONTEXT_CONTENT_ELEMENT = 'contentElement';
    const CONTEXT_FRONTEND_MODULE = 'frontendModule';
    const CONTEXT_READER_BUNDLE = 'readerBundle';
    const CONTEXT_LIST_BUNDLE = 'listBundle';

    /**
     * @var ContaoFrameworkInterface
     */
    private $framework;

    public function __construct(ContaoFrameworkInterface $framework)
    {
        $this->framework = $framework;
    }

    /**
     * Create a new YoutubeConfig element based on given context.
     *
     * @return YoutubeConfigInterface
     */
    public function createConfig(string $context, array $config = null)
    {
        switch ($context) {
            case static::CONTEXT_READER_BUNDLE:
            case static::CONTEXT_LIST_BUNDLE:
                return new YoutubeTwigConfig($this->framework, $config);

            case static::CONTEXT_CONTENT_ELEMENT:
            case static::CONTEXT_FRONTEND_MODULE:
            default:
                return new YoutubeConfig($this->framework, $config);
        }
    }
}
