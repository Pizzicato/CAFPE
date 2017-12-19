'use strict';

const path = require('path');
const merge = require('webpack-merge');
const parts = require("./webpack.config.parts");

const PATHS = {
    src: path.resolve(__dirname, '..', 'html', 'assets', 'src'),
    dist: path.resolve(__dirname, '..', 'html', 'assets', 'dist'),
};

process.env.DIST_PATH = process.env.PUBLIC_PATH + 'assets/dist/';

let isVendor = ({
    resource
}) => /node_modules/.test(resource);

module.exports = merge(
    {
        entry: {
            app: path.resolve(PATHS.src, 'jscripts', 'app', 'index.js'),
            admin: path.resolve(PATHS.src, 'jscripts', 'admin', 'index.js'),
        },
        output: {
            filename: 'jscripts/[name].js',
            path: PATHS.dist,
        }
    },
    parts.setEnvVar('DIST_PATH', process.env.DIST_PATH),
    parts.setEnvVar('PUBLIC_PATH', process.env.PUBLIC_PATH),
    parts.loadFonts({
        exclude: /tinymce/,
        options: {
            name: '[name].[ext]',
            outputPath: 'fonts/',
            publicPath: process.env.DIST_PATH,
        },
    }),
    parts.cleanPath({
        path: PATHS.dist,
        options: {
            allowExternal: true,
            exclude: ['img']
        }
    }),
    parts.providePlugin({
        $: 'jquery',
        jQuery: 'jquery',
        'window.jQuery': 'jquery',
        Popper: ['popper.js', 'default']
    }),
    parts.ignorePlugin(/moment/),
    parts.extractBundles([{
        name: "app.vendors",
        chunks: ['app'],
        minChunks: isVendor
    }, {
        name: "admin.vendors",
        chunks: ['admin'],
        minChunks: isVendor
    }, ]),
);
