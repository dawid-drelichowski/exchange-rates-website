(function(describe, it, expect, beforeEach, spyOn, angular) {
    'use strict';

    describe('RatesControllerTest', function () {
        var scope;

        beforeEach(function() {
            angular.mock.module('ratesAdminApp');
            angular.mock.inject(function($controller, $rootScope){
                scope = $rootScope.$new();
                $controller('RatesController', {$scope: scope});
            });
        });

        it('broadcasts "addRate" event when rate added', function () {
            spyOn(scope, '$broadcast').and.callThrough();
            scope.add();
            expect(scope.$broadcast).toHaveBeenCalledWith('addRate', 0);
        });

        it('do not destroys rate when not existing rate removed', function () {
            var rateScope = scope.$new();

            spyOn(rateScope, '$destroy');
            scope.remove(3);
            expect(rateScope.$destroy.calls.any()).toBeFalsy();
        });

        it('destroys rate when existing rate removed', function () {
            var rateScope = scope.$new();

            spyOn(rateScope, '$destroy');
            rateScope.$emit('registerRate', rateScope);
            scope.remove(0);
            expect(rateScope.$destroy.calls.count()).toEqual(1);
        });
    });
})(describe, it, expect, beforeEach, spyOn, angular);