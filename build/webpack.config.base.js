const path = require('path');
const webpack = require('webpack');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');

const {
    SRC,
    DIST,
    ASSETS
} = require('./webpack.config.paths');

isVendor = ({
    resource
}) => /node_modules/.test(resource);

module.exports = {
    entry: {
        app: path.resolve(SRC, 'jscripts', 'app', 'index.js'),
        admin: path.resolve(SRC, 'jscripts', 'admin', 'index.js')
    },
    module: {
        rules: [{
            test: /.(ttf|otf|eot|svg|woff(2)?)(\?[a-z0-9]+)?$/,
            exclude: /tinymce/,
            use: [{
                loader: 'file-loader',
                options: {
                    name: '[name].[ext]',
                    outputPath: 'fonts/',
                    publicPath: '/assets/dist/'
                }
            }]
        }]
    },
    output: {
        filename: 'jscripts/[name].js',
        path: path.resolve(DIST)
    },
    plugins: [
        new CleanWebpackPlugin([DIST], {
            allowExternal: true,
            exclude: ['img']
        }),
        new webpack.IgnorePlugin(/moment/),
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
            'window.jQuery': 'jquery',
            Popper: ['popper.js', 'default']
        }),
        new webpack.optimize.CommonsChunkPlugin({
            name: "app.vendors",
            chunks: ['app'],
            minChunks: isVendor
        }),
        new webpack.optimize.CommonsChunkPlugin({
            name: "admin.vendors",
            chunks: ['admin'],
            minChunks: isVendor
        })
    ]
};
