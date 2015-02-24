(function(angular) {
    'use strict';

    angular.module('ratesAdminApp', [])
        .controller('RatesController', function($scope) {
            var rates = [];

            $scope.$on('registerRate', function(event, data) {
                rates.push(data);
            });

            $scope.remove = function(index) {
                if (index in rates) {
                    rates[index].$destroy();
                    rates.slice(index, 1);
                }
            };

            $scope.add = function() {
                $scope.$broadcast('addRate', rates.length);
            }
        })
        .directive('rates', function($compile, $templateCache) {
            return {
                restrict: 'A',
                scope: true,
                link: function(scope, element, attrs) {
                    var type = angular.isDefined(attrs.rates) ? attrs.rates : '';

                    scope.$on('addRate', function(event, index) {
                        element.append($compile(
                            $templateCache.get(type + 'Prototype.html').replace(/__name__/g, index)
                        )(scope.$new()));
                    });
                }
            }
        })
        .directive('rate', function() {
            return {
                restrict: 'A',
                scope: {},
                link: function(scope, element) {
                    scope.$on('$destroy', function () {
                        element.remove();
                    });

                    scope.$emit('registerRate', scope);
                }
            }
        });
})(angular);