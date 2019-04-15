let Encore = require('@symfony/webpack-encore');
const CopyWebpackPlugin = require('copy-webpack-plugin');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')

    .createSharedEntry('layout', './assets/js/layout.js')
    .addEntry('rep_log', './assets/js/rep_log.js')
    .addEntry('login', './assets/js/login.js')
    .enableSingleRuntimeChunk()

    .enableBuildNotifications()
    .autoProvidejQuery()

    .addPlugin(new CopyWebpackPlugin([
        { from: './assets/static', to: 'static' }
    ]))

    .enableSassLoader()
    .enableSourceMaps(!Encore.isProduction())
    .cleanupOutputBeforeBuild()
    .enableVersioning(Encore.isProduction())
    .enableReactPreset()
    .configureBabel((babelConfig) => {
        if(Encore.isProduction()) {
            babelConfig.plugins.push('transform-react-remove-prop-types')
        }
    })
;

module.exports = Encore.getWebpackConfig();

