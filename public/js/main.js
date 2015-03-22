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
            url: '/document',
            controller: 'DocumentController',
            controllerAs : 'documentCtrl',
            templateUrl: 'document/document.html'
        })
        .state('document.new', {
            url: '/new',
            templateUrl: 'document/document-new.html'
        })
        .state('document.view', {
            url: '/:document_name',
            templateUrl: 'document/document-view.html'
        })
        .state('.node', {
            url: '/:document_name/:path',
            controller: 'NodeController',
            controllerAs: 'nodeCtrl',
            templateUrl: 'node/node.html'
        });
});

/** Document Controller */

cvApp.controller('DocumentController', ['DocumentData', function(DocumentData){
    var documentCtrl = this;

    this.newDocument = {
        name: '',
        data: ''
    };

    /**
     * View a document with the given name
     *
     * @param documentName
     */
    this.createDocument = function() {
        var documentName = documentCtrl.newDocument.name;
        var documentData = documentCtrl.newDocument.data;
        DocumentData.createDocument(documentName, documentData).success(function(data){
            documentCtrl.newDocument = {
                name: '',
                data: ''
            };
        });
    }

    /**
     * View a document with the given name
     *
     * @param documentName
     */
    this.viewDocument = function(documentName) {
        DocumentData.getDocument(documentName).success(function(data){
            documentCtrl.document = data;
        });
    }


}]);

/**
 * Service to provide Document Data
 */

cvApp.service('DocumentData', function($http) {

    this.getDocument = function (documentName) {
        return $http.get('/api/' + documentName);
    }

    this.createDocument = function (documentName, documentData) {
        return $http.put('/api/' + documentName, documentData);
    }
});


/** Node Controller */

cvApp.controller('NodeController', ['NodeData', function(NodeData){
    var nodeCtrl = this;

}]);

/**
 * Service to provide Node Data
 */

cvApp.service('NodeData', function($http) {
    this.getNode = function (documentName, nodePath) {
        return $http.get('/api/' + document_name + '/' + nodePath);
    }
});

//# sourceMappingURL=main.js.map