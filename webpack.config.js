var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('src/Resources/public/js/')
    .addEntry('contao-youtube-bundle', './src/Resources/assets/js/contao-youtube-bundle.js')
    .setPublicPath('/public/js/')
    .disableSingleRuntimeChunk()
    .addExternals({
        'alertifyjs': 'alertify',
        '@hundh/contao-utils-bundle': 'utilsBundle'
    })
    .configureBabel(function (babelConfig) {
    }, {
        // include to babel processing
        includeNodeModules: ['@hundh/contao-youtube-bundle']
    })
    .enableSourceMaps(!Encore.isProduction())
;

module.exports = Encore.getWebpackConfig();