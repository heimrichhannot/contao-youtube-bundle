<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YoutubeBundle\Video;

use Contao\BackendUser;
use Contao\CoreBundle\Monolog\ContaoContext;
use Contao\Environment;
use Contao\FilesModel;
use Contao\Folder;
use Contao\System;
use HeimrichHannot\YoutubeBundle\Exception\InvalidYoutubeApiKeyException;
use Psr\Log\LogLevel;

trait YoutubeVideoTemplateDataTrait
{
    protected static $privacyCount = 0;

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
     */
    public function hasPreviewImage(): bool
    {
        return true === $this->getConfig()->isAddPreviewImage() || true === $this->config->isYoutubePrivacy();
    }

    /**
     * Get the preview image.
     *
     * @return string|array
     */
    public function getPreviewImage()
    {
        $path = '';
        $cache = true;

        if (false === $this->hasPreviewImage()) {
            return $path;
        }

        if (true === $this->getConfig()->isAddPreviewImage() && '' !== $this->getConfig()->getPreviewImage()) {
            /* @var FilesModel $model */
            $model = $this->framework->getAdapter(FilesModel::class);

            if (null !== ($model = $model->findByUuid($this->getConfig()->getPreviewImage()))) {
                $path = $model->path;
            }
        } else {
            $cache = false === (bool) System::getContainer()->get('huh.utils.dca')->getOverridableProperty('youtubeSkipImageCaching', [(object) $GLOBALS['TL_CONFIG'], $this->config->getRootPage()]);

            $path = $this->getYoutubePreviewImage($cache);
        }

        if ('' !== $path) {
            $imageData = [];

            // local image
            if (true === $cache) {
                System::getContainer()->get('huh.utils.image')->addToTemplateData(
                    'singleSRC',
                    'addImage',
                    $imageData,
                    [
                        'singleSRC' => $path,
                        'addImage' => true,
                        'size' => $this->getConfig()->getSize(),
                        'alt' => $this->getConfig()->getYoutube(),
                    ]
                );
            } // base64 image
            else {
                $imageData['picture']['lazyload'] = false;
                $imageData['picture']['img']['src'] = $path;
                $imageData['picture']['img']['srcset'] = false;
                $imageData['picture']['sources'] = false;
                $imageData['picture']['alt'] = $this->getConfig()->getYoutube();
                $imageData['picture']['img']['width'] = ''; // no dimensions can be set
                $imageData['picture']['img']['height'] = ''; // no dimensions can be set
            }

            return $imageData;
        }

        return $path;
    }

    /**
     * Get the preview image from youtube.
     *
     * @param bool $cache Enable/disable image caching
     */
    public function getYoutubePreviewImage(bool $cache = true): string
    {
        if (!$this->getConfig()->isAddPreviewImage()) {
            return '';
        }

        $cacheName = $this->config->getYoutube().'.jpg';
        $cachePath = rtrim(static::VIDEO_IMAGE_CACHE_DIR, \DIRECTORY_SEPARATOR).\DIRECTORY_SEPARATOR.$cacheName;
        $cachePathAbs = System::getContainer()->get('huh.utils.container')->getProjectDir().\DIRECTORY_SEPARATOR.$cachePath;
        $cacheDirAbs = System::getContainer()->get('huh.utils.container')->getProjectDir().\DIRECTORY_SEPARATOR.static::VIDEO_IMAGE_CACHE_DIR;

        if ($cache && file_exists($cachePathAbs) && filesize($cachePathAbs) > 0 && time() < filemtime($cachePathAbs) + static::VIDEO_IMAGE_CACHE_EXPIRE) {
            return $cachePath;
        }

        if (!($apiKey = System::getContainer()->get('huh.utils.dca')->getOverridableProperty('youtubeApiKey', [(object) $GLOBALS['TL_CONFIG'], $this->config->getRootPage()]))) {
            $result = [
                'items' => [
                    0 => [],
                ],
            ];

            foreach (['maxres' => 'maxresdefault', 'standard' => 'default', 'high' => 'hqdefault', 'medium' => 'mqdefault', 'default' => 'default'] as $quality => $name) {
                $url = sprintf(static::YOUTUBE_IMAGE_URL, $this->config->getYoutube(), $name.'.jpg');
                $response = System::getContainer()->get('huh.utils.request.curl')->request($url, [], true);

                if (200 === $response[0]['http_code']) {
                    $result['items'][0]['snippet']['thumbnails'][$quality] = [
                        'url' => $url,
                        'width' => '',
                        'height' => '',
                    ];
                }
            }

            if (empty($result)) {
                if (!($apiKey = System::getContainer()->get('huh.utils.dca')->getOverridableProperty('youtubeApiKey', [(object) $GLOBALS['TL_CONFIG'], $this->config->getRootPage()]))) {
                    if (BackendUser::getInstance()->isAdmin) {
                        throw new InvalidYoutubeApiKeyException('Please specify your API key in the settings if you want to retrieve youtube thumbnails.');
                    }

                    System::getContainer()->get('monolog.logger.contao')->log(LogLevel::ERROR, 'Please specify your API key in the settings if you want to retrieve youtube thumbnails.', ['contao' => new ContaoContext(__METHOD__, TL_ERROR)]);

                    return '';
                }
            }
        } else {
            $url = sprintf(static::VIDEO_IMAGE_URL, $this->config->getYoutube(), $apiKey);

            $result = System::getContainer()->get('huh.utils.request.curl')->request($url);
        }

        try {
            if (!\is_array($result)) {
                $result = json_decode($result, true);
            }

            if ($result['error'] || !\is_array($result['items']) || empty($result['items'])) {
                return '';
            }

            foreach (['maxres', 'high', 'standard', 'medium', 'default'] as $quality) {
                if (isset($result['items'][0]['snippet']['thumbnails'][$quality])) {
                    $image = System::getContainer()->get('huh.utils.request.curl')->request($result['items'][0]['snippet']['thumbnails'][$quality]['url']);

                    if (!$image) {
                        return '';
                    }

                    $type = pathinfo($result['items'][0]['snippet']['thumbnails'][$quality]['url'], PATHINFO_EXTENSION);

                    if ($cache) {
                        if (!file_exists($cacheDirAbs)) {
                            new Folder(static::VIDEO_IMAGE_CACHE_DIR);
                        }

                        $file = new \File($cachePath);
                        $file->write($image);
                        $file->close();

                        return $file->value;
                    }

                    return 'data:image/'.$type.';base64,'.base64_encode($image);
                }
            }
        } catch (\Exception $e) {
            return '';
        }

        return '';
    }

    /**
     * Render the privacy template.
     *
     * @throws \Twig_Error_Loader  When the template cannot be found
     * @throws \Twig_Error_Syntax  When an error occurred during compilation
     * @throws \Twig_Error_Runtime When an error occurred during rendering
     */
    public function getPrivacy(): string
    {
        if (false === $this->config->isYoutubePrivacy()) {
            return '';
        }

        $data = [
            'host' => Environment::get('host'),
            'count' => static::$privacyCount++,
        ];

        return addslashes(System::getContainer()->get('twig')->render(
            System::getContainer()->get('huh.utils.template')->getTemplate($this->getConfig()->getPrivacyTemplate()),
            $data
        ));
    }

    /**
     * Check add play button.
     */
    public function hasPlayButton(): bool
    {
        return true === $this->config->isYoutubePrivacy() || $this->config->isAddPlayButton();
    }
}
