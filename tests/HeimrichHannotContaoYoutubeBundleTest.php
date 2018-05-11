<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\YoutubeBundle\Tests;

use Contao\TestCase\ContaoTestCase;
use HeimrichHannot\YoutubeBundle\DependencyInjection\HeimrichHannotContaoYoutubeExtension;
use HeimrichHannot\YoutubeBundle\HeimrichHannotContaoYoutubeBundle;

class HeimrichHannotContaoYoutubeBundleTest extends ContaoTestCase
{
    /**
     * Tests the object instantiation.
     */
    public function testCanBeInstantiated()
    {
        $bundle = new HeimrichHannotContaoYoutubeBundle();
        $this->assertInstanceOf(HeimrichHannotContaoYoutubeBundle::class, $bundle);
    }

    /**
     * Tests the getContainerExtension() method.
     */
    public function testReturnsTheContainerExtension()
    {
        $bundle = new HeimrichHannotContaoYoutubeBundle();
        $this->assertInstanceOf(HeimrichHannotContaoYoutubeExtension::class, $bundle->getContainerExtension());
    }
}
