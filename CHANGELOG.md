# Changelog
All notable changes to this project will be documented in this file.

## [3.10.0] - 2022-11-01
- Added: encore contracts support ([#10])
- Changed: raised contao and php dependencies ([#10])
- Changed: assets added automatically for content elements and news entries ([#10])

## [3.9.12] - 2022-09-28
- Fixed: invalid return value in YoutubeConfig

## [3.9.11] - 2022-09-27
- Fixed: warning if contao calendar bundle is not installed

## [3.9.10] - 2022-05-13
- Fixed: type issue

## [3.9.9] - 2022-05-13
- Fixed: exception ins some cases (invalid stringable check)

## [3.9.8] - 2022-05-05
- Fixed: twig integration

## [3.9.7] - 2022-01-11
- Fixed: issues with usercentrics

## [3.9.6] - 2022-01-11
- Fixed: empty element if previewImage option is set but preview image not found (shows now a placeholder image)

## [3.9.5] - 2021-06-25
- fixes for latest webpack-encore

## [3.9.4] - 2021-02-04
- packagist error

## [3.9.3] - 2021-02-04
- fixed preview image generation
- fixed palette handling in tl_news and tl_calendar_events

## [3.9.2] - 2020-11-06
- fixed play button to be html  button when preview image is not set

## [3.9.1] - 2020-10-20
- removed span from play-button
- added aria-label to play-button

## [3.9.0] - 2020-10-20
- fixed play button to be html button element
- added translated text to play button with sr-only class

## [3.8.0] - 2020-08-05
- added logic to obtain youtube-video thumbnail if API-key is not set
- added preview_fallback image if preview image is not set
- fixed template to show privacy-message if preview Image is not set

## [3.7.10] - 2020-07-27
- fix typo

## [3.7.9] - 2020-07-13
- fixed dca fields taken from core tl_content(replaced with full configuration)

## [3.7.8] - 2020-07-13
- fixed `autoplay` field dca configuration

## [3.7.7] - 2020-06-30
- ie11 compatibility issue

## [3.7.6] - 2020-06-30
- add some translations 

## [3.7.3] - 2020-03-31
- replaced non-working PaletteManipulator with str_replace

## [3.7.2] - 2020-03-31
- fixed default youtube template name

## [3.7.1] - 2020-03-31
- fixed issue with contao 4.9 rootfallback palette

## [3.7.0] - 2019-12-19
- added migration command

## [3.6.1] - 2019-12-03
- updated service definitons for symfony 4 (#6)

## [3.6.0] - 2019-12-03
- refactored dialog creation of an alertify modal dialog
- added CustomEvent 'huh.youtube.event.alertify.onshow' to interact with alertifyjs 'onshow' event
- added CustomEvent 'huh.youtube.event.alertify.onfocus' to interact with alertifyjs 'onfocus' event

## [3.5.2] - 2019-11-11
- fixed translations for privacy modal buttons
- updated js
- integrated node module in bundle repo

## [3.5.1] - 2019-11-11
- translations for privacy modal buttons

## [3.5.0] - 2019-08-27

### Added
- youtube twig filter

## [3.4.1] - 2019-08-20

### Fixed
- relatedYoutubeNews tagsinput issue

## [3.4.0] - 2019-06-12

### Added
- `ce_youtube_bs4.html5` template in order to work together with `heimrichhannot/contao-twig-templates-bundle`

## [3.3.4] - 2019-05-29

### Added
- License

## [3.3.3] - 2019-05-28

### Fixed
- `heimrichhannot/contao-reader-bundle` and `heimrichhannot/contao-list-bundle` support, fix contao manager plugin loading order (otherwise dca fields wont be registered properly, or deleted if already existing) 

## [3.3.2] - 2019-03-20

### Fixed
- webpack/encore issues

## [3.3.1] - 2019-03-20

### Fixed
- translation for the new behavior for the "rel" embed parameter
- showInfo is now passed correctly to the template

## [3.3.0] - 2019-03-18

### Fixed
- js handling -> js is now a separate node module importable in other modules
- alertify issue for non webpack/encore environments

## [3.2.1] - 2019-02-18

### Fixed
- contao 4.6 compatibility (dropped `symfony/framework-bundle` requirement from composer.json)

## [3.2.0] - 2019-01-24

### Fixed
- dropped `frameborder="0"` from iframe as it is no longer allowed in html5

### Added
- `allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"` to iframe in order to handle cross site scripting iframe permission

## [3.1.2] - 2019-01-23

#### Fixed
- issue https://github.com/heimrichhannot/contao-youtube-bundle/issues/2

## [3.1.1] - 2019-01-23

#### Added
- `@hundh/contao-utils-bundle`

## [3.1.0] - 2019-01-15

#### Added
- `tl_calendar_events` support

#### Fixed
- `heimrichhannot/contao-reader-bundle` config element type implementation
- translations

## [3.0.1] - 2018-12-19

#### Fixed
- dynamic imports

## [3.0.0] - 2018-12-19

#### Added
- refactoring of javascript to be one code base for modern and legacy environments (EcmaScript modules and vanilla)
- alertifyjs as dialog lib

#### Removed
- bootbox.js as it requires jQuery


[#10]: https://github.com/heimrichhannot/contao-youtube-bundle/pull/10