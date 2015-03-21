/** CV App Module */

var cvApp = angular.module('cvApp', ['ngRoute']);

cvApp.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

/** Angular Routing Config */

cvApp.config( function($routeProvider) {
    $routeProvider
        .when('/:document_name', { controller: 'DocumentController', templateUrl: './document/document.html' })
        .when('/:document_name/:path', { controller: 'DocumentController', templateUrl: './document/node.html' })
        .otherwise({ redirect: '/' });
});

/** Document Controller */

cvApp.controller('DocumentController', ['DocumentData', function(DocumentData){
    var documentCtrl = this;
    DocumentData.getDocument('test-document').success(function(data){
        documentCtrl.document = data;
    });

    console.log("DocumentController");
}]);

/**
 * Service to provide Document Data
 */

cvApp.service('DocumentData', function($http) {
    this.getDocument = function (document_name) { return $http.get('/api/' + document_name); }
});


//# sourceMappingURL=main.js.map