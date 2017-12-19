'use strict';

process.env.PUBLIC_PATH = '/';

const config = require('./webpack.config.prod_stage');

module.exports = config;
