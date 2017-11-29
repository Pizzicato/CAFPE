'use strict';

process.env.PUBLIC_PATH = '/~pabloguaza/assets/dist/';

const config = require('./webpack.config.prod_stage');

module.exports = config;
