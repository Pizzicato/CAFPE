'use strict';

const merge = require('webpack-merge');
const parts = require('./webpack.config.parts');

process.env.PUBLIC_PATH = '/assets/dist/';

const devConfig = merge(
    {
        watch: true,
    },
    parts.loadSCSS(),
    parts.startServer({
        host: 'localhost',
        port: 3000,
        proxy: 'http://localhost:8020/',
        notify: false,
        files: ['application/config/**/*.php', 'application/controllers/*.php', 'application/core/*.php', 'application/helpers/*.php', 'application/hooks/*.php', 'application/language/**/*.php', 'application/libraries/*.php', 'application/models/*.php', 'application/views/**/*.php'],
    }),
    parts.generateSourceMaps({
        exclude: /vendors\.js$/
    }),
);
const commonConfig = require('./webpack.config.common');


module.exports = merge(commonConfig, devConfig);
