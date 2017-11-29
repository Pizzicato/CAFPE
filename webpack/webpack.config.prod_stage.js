'use strict';

const merge = require('webpack-merge');
const parts = require('./webpack.config.parts');

const devConfig = merge(
    parts.extractSCSS(),
    parts.minifyJavaScript({
        sourceMap: true,
        uglifyOptions: {
            output: {
                ascii_only: true,
                comments: false,
            },
        },
    }),
    parts.generateSourceMaps({
        exclude: /vendors\.js$/,
        filename: '[file].map',
        append: false
    }),
);
const commonConfig = require('./webpack.config.common');


module.exports = merge(commonConfig, devConfig);
