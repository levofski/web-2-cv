/** CV App Module */

var cvApp = angular.module('cvApp', ['ui.router']);

cvApp.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

/** Angular UI Routing Config */

cvApp.config( function($stateProvider) {
    $stateProvider
        .state('document', {
            url: '',
            controller: 'DocumentsController',
            controllerAs : 'documentsCtrl',
            templateUrl: 'documents/documents.html',
            resolve: {
                documents: function(DocumentService){
                    return DocumentService.getDocuments();
                }
            }
        })
        .state('document.new', {
            url: '/new',
            templateUrl: 'document/document-new.html'
        })
        .state('document.view', {
            url: '/:document_name',
            templateUrl: 'document/document-view.html',
            controller: 'DocumentController',
            controllerAs : 'documentCtrl',
            resolve: {
                document: function($stateParams, DocumentService, documentData){
                    return {
                        name: $stateParams.document_name,
                        data: documentData.data
                    };
                },
                documentData: function($stateParams, DocumentService){
                    return DocumentService.getDocument($stateParams.document_name);
                }
            }
        })
        .state('.node', {
            url: '/:document_name/:path',
            controller: 'NodeController',
            controllerAs: 'nodeCtrl',
            templateUrl: 'node/node.html'
        });
});

/** Document Controller */

cvApp.controller('DocumentController', ['DocumentService', 'document',  function(DocumentService, document){
    var documentCtrl = this;

    this.document = document;

    /**
     * Create a document with the given name
     *
     * @param documentName
     */
    this.createDocument = function() {
        var documentName = documentCtrl.document.name;
        var documentData = documentCtrl.document.data;
        DocumentService.createDocument(documentName, documentData).success(function(data){
            documentCtrl.document = {
                name: '',
                data: ''
            };
        });
    }

}]);

/**
 * Service to provide Document Data
 */

cvApp.service('DocumentService', ['$http', function($http) {

    this.getDocuments = function () {
        return $http.get('/api/');
    }

    this.getDocument = function (documentName) {
        return $http.get('/api/' + documentName);
    }

    this.createDocument = function (documentName, documentData) {
        return $http.put('/api/' + documentName, documentData);
    }
}]);


/** Documents Controller */

cvApp.controller('DocumentsController', ['documents',  function(documents){
    var documentsCtrl = this;

    this.documents = documents;

}]);

/** Node Controller */

cvApp.controller('NodeController', ['NodeData', function(NodeData){
    var nodeCtrl = this;

}]);

/**
 * Service to provide Node Data
 */

cvApp.service('NodeService', function($http) {
    this.getNode = function (documentName, nodePath) {
        return $http.get('/api/' + document_name + '/' + nodePath);
    }
});

//# sourceMappingURL=main.js.map