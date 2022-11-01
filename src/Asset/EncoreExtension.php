<?php

/*
 * Copyright (c) 2022 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YoutubeBundle\Asset;

use HeimrichHannot\EncoreContracts\EncoreEntry;
use HeimrichHannot\EncoreContracts\EncoreExtensionInterface;
use HeimrichHannot\YoutubeBundle\HeimrichHannotContaoYoutubeBundle;

class EncoreExtension implements EncoreExtensionInterface
{
    public function getBundle(): string
    {
        return HeimrichHannotContaoYoutubeBundle::class;
    }

    public function getEntries(): array
    {
        return [
            EncoreEntry::create('contao-youtube-bundle', 'src/Resources/assets/js/contao-youtube-bundle.js')
                ->addJsEntryToRemoveFromGlobals('alertifyjs')
                ->addCssEntryToRemoveFromGlobals('alertifyjs')
                ->addJsEntryToRemoveFromGlobals('contao-youtube-bundle')
                ->addCssEntryToRemoveFromGlobals('contao-youtube-bundle'),
            EncoreEntry::create('contao-youtube-bundle-theme', 'src/Resources/assets/js/contao-youtube-bundle-theme.js')
                ->setRequiresCss(true),
        ];
    }
}
