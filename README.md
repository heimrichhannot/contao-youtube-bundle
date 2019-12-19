# YouTube

[![](https://img.shields.io/packagist/v/heimrichhannot/contao-youtube-bundle.svg)](https://packagist.org/packages/heimrichhannot/contao-youtube-bundle)
[![](https://img.shields.io/packagist/dt/heimrichhannot/contao-youtube-bundle.svg)](https://packagist.org/packages/heimrichhannot/contao-youtube-bundle)
[![Build Status](https://travis-ci.org/heimrichhannot/contao-youtube-bundle.svg?branch=master)](https://travis-ci.org/heimrichhannot/contao-youtube-bundle)
[![Coverage Status](https://coveralls.io/repos/github/heimrichhannot/contao-youtube-bundle/badge.svg?branch=master)](https://coveralls.io/github/heimrichhannot/contao-youtube-bundle?branch=master)

YouTube bundle aims responsive youtube videos with preview images and better privacy control.
It provides support for content elements and news items.

**An valid [Youtube Data API Key](https://developers.google.com/youtube/v3/getting-started) is required for automatic preview image support (enter on in contao system settings or on your root page).** 

> If you upgrade from heimrichhannot/contao-youtube, see the [upgrade notices](#upgrade-notice-from-heimrichhannotcontao-youtube).

## Features
 
* Responsive youtube videos
* Preview image for youtube videos
    * If no custom image is given, the preview image will be loaded from youtube and saved under 'files/media/youtube/' 
* ConfigElements for [List-](https://github.com/heimrichhannot/contao-list-bundle) and [Readerbundle](https://github.com/heimrichhannot/contao-reader-bundle).
* Privacy mode 
    * In privacy mode the video is displayed, after the user accepted a privacy advice within a modal prompt
    * The user can mark his selection as permanent with a checkbox (state will be saved in a cookie)

![alt privacy modal](./docs/img/privacy_modal.jpg)

## Technical instruction

### Add to list and reader item templates

For usage with [List-](https://github.com/heimrichhannot/contao-list-bundle) and [Readerbundle](https://github.com/heimrichhannot/contao-reader-bundle) you first need to add the config elements in List- and/or Reader config.

Afterwards you can add youtube to your template. The config elements add a formatted value `youtubeVideos` containing an array for each youtube field add by an config element.

```php
$templateData = [
    // ...
    'youtubeVideos' => [
        'youtubeField' => [ // The selected youtube field name from config element
            'video' => '' // Generated default template,
            'data' => [] // Video data for custom templates
        ]
    ]
]
``` 

Example custom template:
```yaml

{% if raw.addYouTube == "1" and youtubeVideos.youtube|default%}
    {% include '@VendorMyBundle/youtube/youtube_video_custom.html.twig' with youtubeVideos.youtube.data %}
{% endif %}
```

### News template

Youtube videos can be added to news templates with ease. Just add the following code (for example: news_full.html5):

```
<?php if($this->youtube && $this->youtube->video): ?>
	<?= $this->youtube->video; ?>
<?php endif; ?>
```

### Preview images from YouTube

To use preview images from youtube, you have to generate an API key (https://developers.google.com/youtube/v3/getting-started) and place it in the contao settings.

### Commands

#### Migration Command

```
Usage:
  huh:youtube:migration [options]

Options:
      --dry-run              Performs a run without writing to database.
      --migration=MIGRATION  Do migration directly without interrupt. Options: module, database, both, none
  -h, --help                 Display this help message
  -q, --quiet                Do not output any message
  -V, --version              Display this application version
      --ansi                 Force ANSI output
      --no-ansi              Disable ANSI output
  -n, --no-interaction       Do not ask any interactive question
  -e, --env=ENV              The Environment name. [default: "prod"]
      --no-debug             Switches off debug mode.
  -v|vv|vvv, --verbose       Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Help:
  This command provide migration scripts to migrate from heimrichhannot/contao-youtube to heimrichhannot/contao-youtube-bundle.
  
  Available migrations:
    'module' updates default template names and field values
    'database' updates database fields that can't be updated by the contao install tool.
    'both' will run 'module' and 'database' migrations.
```


## Developers

### Events

Event | Event ID
----- | ---------
Event to interact with AlertifyJs 'onshow' event | `huh.youtube.event.alertify.onshow`
Event to interact with AlertifyJs 'onfocus' event | `huh.youtube.event.alertify.onfocus`

## Upgrade notice from heimrichhannot/contao-youtube

- Use `huh:youtube:migration` command to migrated the default template settings in root pages and relatedYoutubeNews database field
- Declare an Youtube-API Key in tl_settings or tl_page (otherwise preview image download wont work)
- The modal windows for privacy dialog or modalvideo require additional css, that is not delivered by the bundle. Markup fits [Bootstrap](http://getbootstrap.com/) modal window css, so you are well-advised to use the css from that framework.
- If you were using custom youtube `.html5` templates, migrate them to `.html.twig` templates, if you need help: check the default templates