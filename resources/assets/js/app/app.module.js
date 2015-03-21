/** CV App Module */

var cvApp = angular.module('cvApp', ['ngRoute']);

cvApp.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});
