const path = require('path');
const defaultConfig = require('@wordpress/scripts/config/webpack.config');

module.exports = {
    ...defaultConfig,
    entry: './block-editor/index.js',
    resolve: {
        ...defaultConfig.resolve,
        fallback: {
            "path": require.resolve("path-browserify")
        },
        alias: {
            ...defaultConfig.resolve.alias,
            '@components': path.resolve(__dirname, 'block-editor/components'),
            '@icons': path.resolve(__dirname, 'block-editor/icons'),
            '@utils': path.resolve(__dirname, 'block-editor/utils'),
            '@services': path.resolve(__dirname, 'block-editor/services'),
            '@scss': path.resolve(__dirname, 'block-editor/scss'),
        },
        fullySpecified: false,
    },
    module: {
        ...defaultConfig.module,
        rules: [
            {
                test: /\.scss$/,
                use: [
                    'css-loader',
                    'postcss-loader',
                    'sass-loader',
                ],
            },
            ...defaultConfig.module.rules,
        ],
    },
};
