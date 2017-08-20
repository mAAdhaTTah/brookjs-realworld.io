const path = require('path');

const client = path.join(__dirname, 'client');

module.exports = {
    entry: {
        app: './client/app.js'
    },
    output: {
        path: path.join(__dirname, 'public', 'assets'),
        publicPath: '/assets',
        filename: '[name].js'
    },
    module: {
        loaders: [
            {
                test: /\.js$/,
                loader: 'eslint-loader',
                include: client,
                enforce: 'pre'
            },
            {
                test: /\.js$/,
                loader: 'babel-loader',
                include: client,
            },
            {
                test: /\.hbs/,
                loader: 'handlebars-loader',
                query: {
                    helperDirs: ['./client/helpers'],
                    partialDirs: ['./client'],
                    preventIndent: true,
                    compat: true
                }
            }
        ]
    },
    resolve: {
        alias: {
            redux: 'redux/es',
            brookjs: 'brookjs/es'
        },
        mainFields: ['module', 'browser', 'main']
    }
};
