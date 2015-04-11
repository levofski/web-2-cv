/** CV App Module */

var cvApp = angular.module('cvApp', ['ui.router', 'ui.bootstrap', 'ui.ace', 'xeditable']);

cvApp.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

cvApp.run(function(editableOptions) {
    editableOptions.theme = 'bs3'; // bootstrap3 theme
});
