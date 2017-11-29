'use strict';

const config = require('./webpack.config.prod_stage');

process.env.PUBLIC_PATH = '/assets/dist/';

module.exports = config;
