# Upgrade

## 1.* to 2.0

### Integrations
* moved reader bundle integration to own [bundle](https://github.com/heimrichhannot/contao-youtube-reader-bundle) 

### Constants
* Removed `ConfigFactory::CONTEXT_READER_BUNDLE` (use `CONTEXT_TWIG` instead)

### Classes
* moved `YouTubeReaderConfigElementType` to own bundle (see Integrations)

### DCA
* moved `tl_reader_config_element` dca and languages to own bundle (see integrations)

## heimrichhannot/contao-youtube to youtube bundle 1.0

- After update, save your root-pages in back end mode again to update template names
- Declare an Youtube-API Key in tl_settings or tl_page (otherwise preview image download wont work)
- The modal windows for privacy dialog or modalvideo require additional css, that is not delivered by the bundle. Markup fits [Bootstrap](http://getbootstrap.com/) modal window css, so you are well-advised to use the css from that framework.
- If you were using custom youtube `.html5` templates, migrate them to `.html.twig` templates, if you need help: check the default templates

