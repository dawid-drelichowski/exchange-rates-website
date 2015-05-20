module.exports = function(config) {
    'use strict';

    config.set({
        files: [
            {pattern: 'js/src/**/*.js', included: false},
            'js/tests/**/*.js'
        ],
        preprocessors: {
            'js/tests/**/*.js': ['webpack']
        },
        webpack: {
            resolve: {
                modulesDirectories: ['node_modules', 'js/src']
            }
        },
        frameworks: ['jasmine'],
        reporters: ['progress'],
        port: 9876,
        colors: true,
        logLevel: config.LOG_INFO,
        autoWatch: false,
        browsers: ['PhantomJS'],
        singleRun: true
  });
};
