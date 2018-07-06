<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YoutubeBundle\ConfigElementType;

use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Contao\FrontendTemplate;
use HeimrichHannot\ReaderBundle\ConfigElementType\ConfigElementType;
use HeimrichHannot\ReaderBundle\Item\ItemInterface;
use HeimrichHannot\ReaderBundle\Model\ReaderConfigElementModel;
use HeimrichHannot\YoutubeBundle\Configuration\YoutubeTwigConfig;
use HeimrichHannot\YoutubeBundle\Video\YoutubeVideo;

class YoutubeReaderConfigElementType implements ConfigElementType
{
    const TYPE = 'youtube';

    /**
     * @var ContaoFrameworkInterface
     */
    private $framework;

    public function __construct(ContaoFrameworkInterface $framework)
    {
        $this->framework = $framework;
    }

    public function addToItemData(ItemInterface $item, ReaderConfigElementModel $readerConfigElement)
    {
        if (!$item->getRawValue($readerConfigElement->typeSelectorField)) {
            return;
        }
        if ((!$typeData = $item->getRawValue($readerConfigElement->typeField)) || empty($typeData)) {
            return;
        }
        $configData = [
            'type' => 'youtube',
            'addYouTube' => true,
            'youtube' => $typeData,
        ];

        $video = new YoutubeVideo($this->framework);
        $videoConfig = new YoutubeTwigConfig($this->framework);
        $videoConfig->setData(array_merge($item->getRaw(), $configData));
        $video->setConfig($videoConfig);
        $template = new FrontendTemplate();
        $video->addToTemplate($template);
        $templateData = $template->getData();
        $item->setFormattedValue('youtubeVideos', [$readerConfigElement->typeField => (array) $templateData['youtube']]);
    }
}
