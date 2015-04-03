/** CV App Module */

var cvApp = angular.module('cvApp', ['ui.router', 'xeditable']);

cvApp.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

cvApp.run(function(editableOptions) {
    editableOptions.theme = 'bs3'; // bootstrap3 theme
});
