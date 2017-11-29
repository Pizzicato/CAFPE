'use strict';

const webpack = require("webpack");
const ExtractTextPlugin = require("extract-text-webpack-plugin");
const CleanWebpackPlugin = require("clean-webpack-plugin");
const UglifyWebpackPlugin = require("uglifyjs-webpack-plugin");
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');


exports.minifyJavaScript = (options) => ({
    plugins: [new UglifyWebpackPlugin(options)],
});

exports.cleanPath = ({
    path,
    options,
} = {}) => ({
    plugins: [new CleanWebpackPlugin([path], options)],
});

exports.loadFonts = ({
    include,
    exclude,
    options,
} = {}) => ({
    module: {
        rules: [{
            test: /.(ttf|otf|eot|svg|woff(2)?)(\?[a-z0-9]+)?$/,
            include,
            exclude,
            use: [{
                loader: 'file-loader',
                options: options,
            }, ],
        }, ],
    },
});

exports.loadSCSS = ({
    include,
    exclude
} = {}) => ({
    module: {
        rules: [{
            test: /\.scss$/,
            include,
            exclude,
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
            }, ],
        }, ],
    },
});

exports.extractSCSS = ({
    include,
    exclude,
} = {}) => {
    // Output extracted SCSS to a file
    const plugin = new ExtractTextPlugin({
        allChunks: true,
        filename: "styles/[name].css",
    });

    return {
        module: {
            rules: [{
                test: /\.scss$/,
                include,
                exclude,

                use: plugin.extract({
                    fallback: "style-loader",
                    use: [{
                            loader: 'css-loader',
                            options: {
                                minimize: true,
                                sourceMap: true,
                                importLoaders: 2,
                            },
                        },
                        {
                            loader: 'postcss-loader',
                            options: {
                                sourceMap: true,
                                plugins: () => [require('autoprefixer')()],
                            },
                        },
                        {
                            loader: 'sass-loader',
                            options: {
                                sourceMap: true,
                            },
                        },
                    ],
                }),
            }, ],
        },
        plugins: [plugin],
    };
};

exports.generateSourceMaps = options => ({
    plugins: [new webpack.SourceMapDevToolPlugin(options)],
});

exports.extractBundles = bundles => ({
    plugins: bundles.map(
        bundle => new webpack.optimize.CommonsChunkPlugin(bundle)
    ),
});

exports.setEnvVar = (key, value) => {
    let obj = {};
    obj[key] = value;
    return {
        plugins: [new webpack.EnvironmentPlugin(obj)],
    }
};

exports.startServer = options => ({
    plugins: [new BrowserSyncPlugin(options)],
});

exports.ignorePlugin = ignore => ({
    plugins: [new webpack.IgnorePlugin(ignore)],
});

exports.providePlugin = options => ({
    plugins: [new webpack.ProvidePlugin(options)],
});
