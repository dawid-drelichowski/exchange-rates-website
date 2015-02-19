(function(angular) {
    'use strict';

    angular.module('ratesAdminApp', [])
        .controller('ratesCtrl', function($templateCache) {
            console.log($templateCache.get('wholesalePrototype.html'));
        });
})(angular);