module.exports = function(config) {
    'use strict';

    config.set({
        files: [
            'web/components/angular/angular.js',
            'web/components/angular-mocks/angular-mocks.js',
            'web/js/**/*.js',
            'tests/**/*.js'
        ],
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
