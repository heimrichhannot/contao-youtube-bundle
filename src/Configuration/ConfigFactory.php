<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YoutubeBundle\Configuration;

use Contao\CoreBundle\Framework\ContaoFrameworkInterface;

class ConfigFactory
{
    const CONTEXT_TWIG = 'twig';
    const CONTEXT_CONTENT_ELEMENT = 'contentElement';
    const CONTEXT_FRONTEND_MODULE = 'frontendModule';

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
     * @param string     $context
     * @param array|null $config
     *
     * @return YoutubeConfigInterface
     */
    public function createConfig(string $context, array $config = null)
    {
        switch ($context) {
            case static::CONTEXT_TWIG:
                return new YoutubeTwigConfig($this->framework, $config);
            case static::CONTEXT_CONTENT_ELEMENT:
            case static::CONTEXT_FRONTEND_MODULE:
            default:
                return new YoutubeConfig($this->framework, $config);
        }
    }
}
