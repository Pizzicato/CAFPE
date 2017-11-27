const path = require('path');
const merge = require('webpack-merge')
const webpack = require('webpack');
const autoprefixer = require('autoprefixer')
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const UglifyJSPlugin = require('uglifyjs-webpack-plugin');

const {
    SRC,
    DIST,
    ASSETS
} = require('./webpack.config.paths')

module.exports = merge(require('./webpack.config.base.js'), {
    module: {
        rules: [{
            test: /\.scss$/,
            use: ExtractTextPlugin.extract({
                fallback: 'style-loader',
                use: [{
                        loader: 'css-loader',
                        options: {
                            minimize: true,
                            sourceMap: true,
                            importLoaders: 2
                        }
                    },
                    {
                        loader: 'postcss-loader',
                        options: {
                            sourceMap: true,
                            plugins: () => [require('autoprefixer')()]
                        }
                    },
                    {
                        loader: 'sass-loader',
                        options: {
                            sourceMap: true
                        }
                    }
                ]
            })
        }]
    },
    plugins: [
        new ExtractTextPlugin({
            allChunks: true,
            filename: 'styles/[name].css'
        }),
        new UglifyJSPlugin({
            sourceMap: true,
            uglifyOptions: {
                output: {
                    ascii_only: true,
                    comments: false
                }
            }
        }),
        new webpack.SourceMapDevToolPlugin({
            exclude: /vendors\.js$/,
            filename: '[file].map',
            append: false
        })
    ]
});
