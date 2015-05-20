var path = require('path'),
    ngAnnotatePlugin = require('ng-annotate-webpack-plugin');

module.exports = {
    context: path.join(__dirname, 'js/src'),
    entry: './admin/app.js',
    output: {
        path: path.join(__dirname, 'web/js'),
        filename: './admin.js'
    },
    plugins: [new ngAnnotatePlugin()]
};