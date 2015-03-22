/** CV App Module */

var cvApp = angular.module('cvApp', ['ngRoute']);

cvApp.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

/** Angular Routing Config */

cvApp.config( function($routeProvider) {
    $routeProvider
        .when('/new', { controller: 'DocumentController', templateUrl: 'document/new.html' })
        .when('/:document_name', { controller: 'DocumentController', templateUrl: 'document/document.html' })
        .when('/:document_name/:path', { controller: 'NodeController', templateUrl: 'node/node.html' })
        .otherwise({ redirect: '/' });
});

/** Document Controller */

cvApp.controller('DocumentController', ['DocumentData', function(DocumentData){
    var documentCtrl = this;
    DocumentData.getDocument('test-document').success(function(data){
        documentCtrl.document = data;
    });


}]);

/**
 * Service to provide Document Data
 */

cvApp.service('DocumentData', function($http) {
    this.getDocument = function (document_name) { return $http.get('/api/' + document_name); }
    this.createDocument = function (document_name) { return $http.put('/api/' + document_name, {}); }
});


//# sourceMappingURL=main.js.map