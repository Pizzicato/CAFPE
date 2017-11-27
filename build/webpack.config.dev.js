const path = require('path');
const merge = require('webpack-merge');
const webpack = require('webpack');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const {
    SRC,
    DIST,
    ASSETS
} = require('./webpack.config.paths')

module.exports = merge(require('./webpack.config.base.js'), {
    watch: true,
    module: {
        rules: [{
            test: /\.scss$/,
            use: [{
                loader: "style-loader"
            }, {
                loader: "css-loader",
                options: {
                    sourceMap: true
                }
            }, {
                loader: "sass-loader",
                options: {
                    sourceMap: true
                }
            }]
        }]
    },
    plugins: [
        new BrowserSyncPlugin({
            host: 'localhost',
            port: 3000,
            proxy: 'http://localhost:8020/',
            notify: false,
            files: ['application/config/**/*.php', 'application/controllers/*.php', 'application/core/*.php', 'application/helpers/*.php', 'application/hooks/*.php', 'application/language/**/*.php',  'application/libraries/*.php', 'application/models/*.php', 'application/views/**/*.php']
        })
        new webpack.SourceMapDevToolPlugin({
            exclude: /vendors\.js$/
        })
    ]
})
