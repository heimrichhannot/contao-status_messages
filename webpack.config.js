var Encore = require('@symfony/webpack-encore');

Encore
.setOutputPath('src/Resources/public/assets/')
.addEntry('contao-status-messages', './src/Resources/assets/js/status_messages.js')
.setPublicPath('/bundles/heimrichhannotstatusmessages/assets')
.setManifestKeyPrefix('bundles/heimrichhannotstatusmessages/assets')
.disableSingleRuntimeChunk()
.enableSourceMaps(false)
;

module.exports = Encore.getWebpackConfig();