(function(describe, it, expect, beforeEach, spyOn, angular) {
    'use strict';

    describe('RatesController test', function () {
        var scope;

        beforeEach(function () {
            angular.mock.module('RatesAdminApp');
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

    describe('Rates directive test', function() {
        var type = {
                name: 'retail',
                id: 1
            },
            indexPlaceholder = '__name__',
            templates = {
                rates: '<div data-rates="' + type.name + '"></div>',
                rate: '<div data-rate>' +
                    '<a data-ng-click="remove(' + indexPlaceholder + ')">&times;</a>' +
                    '<div>' +
                        '<label for="form_' + type.name + '_' + indexPlaceholder + '_country" class="required">Country</label>' +
                        '<input type="text" id="form_' + type.name + '_' + indexPlaceholder + '_country" name="form[' + type.name + '][' + indexPlaceholder + '][country]" required="required" maxlength="50" />' +
                    '<div/>' +
                    '<div>' +
                        '<label for="form_' + type.name + '_' + indexPlaceholder + '_currency" class="required">Currency</label>' +
                        '<input type="text" id="form_' + type.name + indexPlaceholder + 'currency" name="form[' + type.name + '][' + indexPlaceholder + '][currency]" required="required" maxlength="10" />' +
                    '</div>' +
                    '<div>' +
                        '<label for="form_' + type.name + '_' + indexPlaceholder + '_purchase" class="required">Purchase</label>' +
                        '<input type="text" id="form_' + type.name + '_' + indexPlaceholder + '_purchase" name="form[' + type.name + '][' + indexPlaceholder + '][purchase]" required="required" />' +
                    '</div>' +
                    '<div>' +
                        '<label for="form_' + type.name + '_' + indexPlaceholder + '_sale" class="required">Sale</label>' +
                        '<input type="text" id="form_' + type.name + '_' + indexPlaceholder + '_sale" name="form[' + type.name + '][' + indexPlaceholder + '][sale]" required="required" />' +
                    '</div>' +
                    '<input type="hidden" id="form_' + type.name + '_' + indexPlaceholder + '_typeId" name="form[' + type.name + '][' + indexPlaceholder + '][typeId]" value="' + type.id + '" />' +
                '</div>'
            },
            scope,
            element;

        beforeEach(function () {
            angular.mock.module('RatesAdminApp');
            angular.mock.inject(function($compile, $rootScope, $templateCache){
                scope = $rootScope.$new();
                element = $compile(templates.rates)(scope);
                $templateCache.put(type.name + 'Prototype.html', templates.rate);
                scope.$digest();
            });
        });

        it('adds new rate when "addRate" event broadcast', function () {
            var index = 1,
                elementContent;

            scope.$broadcast('addRate', index);
            elementContent = element.html();
            expect(angular.element(elementContent).length).toEqual(1);
            expect(elementContent).not.toContain(indexPlaceholder);
            expect(elementContent).toContain(type.name);
        });
    });
})(describe, it, expect, beforeEach, spyOn, angular);