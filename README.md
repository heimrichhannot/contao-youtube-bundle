# YouTube

[![](https://img.shields.io/packagist/v/heimrichhannot/contao-youtube-bundle.svg)](https://packagist.org/packages/heimrichhannot/contao-youtube-bundle)
[![](https://img.shields.io/packagist/dt/heimrichhannot/contao-youtube-bundle.svg)](https://packagist.org/packages/heimrichhannot/contao-youtube-bundle)
[![Build Status](https://travis-ci.org/heimrichhannot/contao-youtube-bundle.svg?branch=master)](https://travis-ci.org/heimrichhannot/contao-youtube-bundle)
[![Coverage Status](https://coveralls.io/repos/github/heimrichhannot/contao-youtube-bundle/badge.svg?branch=master)](https://coveralls.io/github/heimrichhannot/contao-youtube-bundle?branch=master)

YouTube bundle aims responsive youtube videos with preview images and better privacy control.
It provides support for content elements and news items.

## Technical instruction

Youtube videos can be added to news templates with ease. Just add the following code (for example: news_full.html5):

```
<?php if($this->youtube && $this->youtube->video): ?>
	<?= $this->youtube->video; ?>
<?php endif; ?>
```

To use preview images from youtube, you have to generate an API key (https://developers.google.com/youtube/v3/getting-started) and place it in the contao settings.

## Features
 
* Responsive youtube videos
* Preview image for youtube videos
    * If no custom image is given, the preview image will be loaded from youtube and saved under 'files/media/youtube/' 
* Privacy mode 
    * In privacy mode the video is displayed, after the user accepted a privacy advice within a modal prompt
    * The user can mark his selection as permanent with a checkbox (state will be saved in a cookie) 

![alt privacy modal](./docs/img/privacy_modal.jpg)