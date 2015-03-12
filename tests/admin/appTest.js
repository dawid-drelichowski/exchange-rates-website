(function(describe, it, expect, beforeEach, spyOn, angular) {
    'use strict';

    describe('RatesControllerTest', function () {
        var $scope;

        beforeEach(function() {
            angular.mock.module('ratesAdminApp');
            angular.mock.inject(function($controller, $rootScope){
                $scope = $rootScope.$new();
                $controller('RatesController', {$scope: $scope});
            });
        });

        it('broadcast "addRate" event when rate added', function () {
            spyOn($scope, '$broadcast').and.callThrough();
            $scope.add();
            expect($scope.$broadcast).toHaveBeenCalledWith('addRate', 0);
        });
    });
})(describe, it, expect, beforeEach, spyOn,angular);