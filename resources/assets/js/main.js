var cvApp = angular.module('cvApp', []);

cvApp.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});