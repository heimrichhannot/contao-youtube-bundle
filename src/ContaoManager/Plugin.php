<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YoutubeBundle\ContaoManager;

use Contao\CalendarBundle\ContaoCalendarBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Config\ContainerBuilder;
use Contao\ManagerPlugin\Config\ExtensionPluginInterface;
use Contao\NewsBundle\ContaoNewsBundle;
use HeimrichHannot\UtilsBundle\Container\ContainerUtil;
use HeimrichHannot\YoutubeBundle\HeimrichHannotContaoYoutubeBundle;

class Plugin implements BundlePluginInterface, ExtensionPluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        $loadAfter = [ContaoCoreBundle::class, 'multi_column_editor', ContaoNewsBundle::class, ContaoCalendarBundle::class];

        // add heimrichhannot/contao-list-bundle support
        if (class_exists('HeimrichHannot\ListBundle\HeimrichHannotContaoListBundle')) {
            $loadAfter[] = 'HeimrichHannot\ListBundle\HeimrichHannotContaoListBundle';
        }

        // add heimrichhannot/contao-reader-bundle support
        if (class_exists('HeimrichHannot\ReaderBundle\HeimrichHannotContaoReaderBundle')) {
            $loadAfter[] = 'HeimrichHannot\ReaderBundle\HeimrichHannotContaoReaderBundle';
        }

        return [
            BundleConfig::create(HeimrichHannotContaoYoutubeBundle::class)->setLoadAfter($loadAfter),
        ];
    }

    /**
     * Allows a plugin to override extension configuration.
     *
     * @param string $extensionName
     *
     * @return
     */
    public function getExtensionConfig($extensionName, array $extensionConfigs, ContainerBuilder $container)
    {
        $extensionConfigs = ContainerUtil::mergeConfigFile(
            'huh_encore',
            $extensionName,
            $extensionConfigs,
            __DIR__.'/../Resources/config/config_encore.yml'
        );
        $extensionConfigs = ContainerUtil::mergeConfigFile(
            'huh_list',
            $extensionName,
            $extensionConfigs,
            __DIR__.'/../Resources/config/huh_list.yml'
        );
        $extensionConfigs = ContainerUtil::mergeConfigFile(
            'huh_reader',
            $extensionName,
            $extensionConfigs,
            __DIR__.'/../Resources/config/huh_reader.yml'
        );

        return $extensionConfigs;
    }
}
