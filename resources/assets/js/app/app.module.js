/** CV App Module */

var cvApp = angular.module('cvApp', ['ui.router']);

cvApp.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

cvApp.filter('objOrder', function () {
    return function(object) {
        var array = [];
        angular.forEach(object, function (value, key) {
            array.push({key: key, value: value});
        });
        return array;
    };
});
