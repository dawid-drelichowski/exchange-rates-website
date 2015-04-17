(function(describe, it, expect, beforeEach, spyOn, angular) {
    'use strict';

    describe('RatesController test', function () {

        beforeEach(function () {
            angular.mock.module('RatesAdminApp');
            angular.mock.inject(function($controller, $rootScope){
                this.scope = $rootScope.$new();
                $controller('RatesController', {$scope: this.scope});
            });
        });

        it('broadcasts "addRate" event when rate added', function () {
            spyOn(this.scope, '$broadcast').and.callThrough();
            this.scope.add();
            expect(this.scope.$broadcast).toHaveBeenCalledWith('addRate', 0);
        });

        it('do not destroys rate when not existing rate removed', function () {
            var rateScope = this.scope.$new();

            spyOn(rateScope, '$destroy');
            this.scope.remove(3);
            expect(rateScope.$destroy.calls.any()).toBeFalsy();
        });

        it('destroys rate when existing rate removed', function () {
            var rateScope = this.scope.$new();

            spyOn(rateScope, '$destroy');
            rateScope.$emit('registerRate', rateScope);
            this.scope.remove(0);
            expect(rateScope.$destroy.calls.count()).toEqual(1);
        });
    });

    describe('Directives', function () {
        var type = {
                name: 'retail',
                id: 1
            },
            indexPlaceholder = '__name__',
            index = 1,
            templates = {
                rates: '<div data-rates="' + type.name + '"></div>',
                rate: '<div data-rate>' +
                    '<a data-ng-click="remove(' + indexPlaceholder + ')">&times;</a>' +
                    '<div>' +
                        '<label for="form_' + type.name + '_' + indexPlaceholder + '_country" class="required">Country</label>' +
                        '<input type="text" id="form_' + type.name + '_' + indexPlaceholder + '_country" name="form[' + type.name + '][' + indexPlaceholder + '][country]" required="required" maxlength="50" />' +
                    '</div>' +
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
            };

        describe('Rates test', function () {

            beforeEach(function () {
                angular.mock.module('RatesAdminApp');
                angular.mock.inject(function ($compile, $rootScope, $templateCache) {
                    this.scope = $rootScope.$new();
                    this.rates = $compile(templates.rates)(this.scope);
                    $templateCache.put(type.name + 'Prototype.html', templates.rate);
                    this.scope.$digest();
                });
            });

            it('adds new rate when "addRate" event broadcast', function () {
                var ratesContent;

                this.scope.$broadcast('addRate', index);
                ratesContent = this.rates.html();
                expect(angular.element(ratesContent).length).toEqual(1);
                expect(ratesContent).not.toContain(indexPlaceholder);
                expect(ratesContent).toContain(type.name);
            });
        });

        describe('Rate test', function () {

            beforeEach(function () {
                angular.mock.module('RatesAdminApp');
                angular.mock.inject(function ($compile, $rootScope) {
                    this.scope = $rootScope.$new();
                    this.compile = function () {
                        return $compile(
                            templates.rate.replace(new RegExp(indexPlaceholder, 'g'), index)
                        )(this.scope);
                    };
                });
            });

            it('emits "registerRate" event when rate added', function () {
                var eventEmitted = false;

                //spyOn(this.scope, '$emit').and.callThrough(); //it doesn't work
                this.scope.$on('registerRate', function () {
                    eventEmitted = true;
                });
                this.compile();

                expect(eventEmitted).toBeTruthy();
                //expect(scope.$emit).toHaveBeenCalledWith('registerRate', scope); //it doesn't work
            });

            it('removes rate when "$destroy" event broadcast', function () {
                var rates = angular.element(templates.rates),
                    rate = this.compile();

                rates.append(rate);
                this.scope.$digest();
                expect(rates.children().length).toEqual(1);

                this.scope.$destroy();
                expect(rates.children().length).toEqual(0);
            });
        });
    });
})(describe, it, expect, beforeEach, spyOn, angular);