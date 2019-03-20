# Changelog
All notable changes to this project will be documented in this file.

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

## [2.1.3] - 2018-10-19

#### Fixed
- translation for `tl_reader_config_element` reference could not be extended by other modules

## [2.1.2] - 2018-10-19

#### Fixed
- youtube config element for list and reader

## [2.1.1] - 2018-09-11

#### Fixed
- refactored news callbacks

## [2.1.0] - 2018-09-10

#### Added
- autoplay feature for reader

## [2.0.1] - 2018-08-22

#### Fixed
- issue in privacy modal

## [2.0.0] - 2018-08-22

#### Changed
- modal handling to bootbox because of issues with sticky elements

## [1.3.3] - 2018-08-21

#### Fixed
- event listener issue in news lists

## [1.3.2] - 2018-08-20

#### Fixed
- privacy modal template

#### Added
- privacy modal custom bs4 controls template

## [1.3.1] - 2018-08-13

#### Fixed
- check on video in `HeimrichHannot\YoutubeBundle\Video\YoutubeVideo::generate`
- check if youtube id is set in `HeimrichHannot\YoutubeBundle\EventListener\HookListener`

## [1.3.0] - 2018-08-06

#### Changes
- refactored config- and videocreation to factory services
- removed config and video services

## [1.2.5] - 2018-07-31

#### Fixed
- news list issues

## [1.2.4] - 2018-07-30

#### Fixed
- php cs fixer config
- gitignore -> vendor

## [1.2.3] - 2018-07-25

#### Fixed
- reader config element localization issue

## [1.2.2] - 2018-07-25

#### Fixed
- reader config element localization issue

## [1.2.1] - 2018-07-06

#### Fixed
- error when data array added to youtube config containing element can't be converted to string

## [1.2.0] - 2018-07-06

#### Added 
- ConfigElement for ListBundle and ReaderBundle
- some english translation 

## [1.1.2] - 2018-06-29

#### Fixed
- `youtube_modalvideo_default.html.twig` - decode html entities `headlineText`

## [1.1.1] - 2018-06-28

#### Fixed
- removed no longer required files

## [1.1.0] - 2018-05-06

#### Added
- `text` to youtube content element

## [1.0.2] - 2018-05-06

#### Changed
- README updated
