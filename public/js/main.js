/** CV App Module */

var cvApp = angular.module('cvApp', ['ui.router']);

cvApp.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

/** Angular UI Routing Config */

cvApp.config( function($stateProvider, $urlRouterProvider) {
    $stateProvider
        .state('document', {
            url: '/',
            controller: 'DocumentsController',
            controllerAs : 'documentsCtrl',
            templateUrl: 'documents/documents.html',
            resolve: {
                documents: function(DocumentService, documentsData){
                    var documentResult = [];
                    var documentsDataData = documentsData.data;
                    for(documentName in documentsDataData){
                        documentResult.push({
                            name: documentName,
                            data: documentsDataData[documentName]
                        });
                    }
                    return documentResult;
                },
                documentsData: function(DocumentService){
                    return DocumentService.getDocuments();
                }
            }
        })
        .state('document.new', {
            url: 'new',
            templateUrl: 'document/document-new.html',
            controller: 'DocumentController',
            controllerAs : 'documentCtrl',
            resolve: {
                documentName: function(){
                    return '';
                },
                documentData: function(){
                    return '';
                }
            }
        })
        .state('document.view', {
            url: ':document_name',
            views: {
                '': {
                    templateUrl: 'document/document-view.html'
                },
                'name@document.view': {
                    templateUrl: 'document/document-name.html',
                    controller: 'DocumentController',
                    controllerAs : 'documentCtrl'
                },
                'data@document.view': {
                    templateUrl: 'document/document-data.html',
                    controller: 'DocumentController',
                    controllerAs : 'documentCtrl'
                }
            },
            resolve: {
                documentName: function($stateParams){
                    return $stateParams.document_name;
                },
                documentDataPromise: function($stateParams, DocumentService){
                    return DocumentService.getDocument($stateParams.document_name);
                },
                documentData: function(documentDataPromise){
                    return documentDataPromise.data;
                }
            }
        })
        .state('.node', {
            url: ':document_name/:path',
            controller: 'NodeController',
            controllerAs: 'nodeCtrl',
            templateUrl: 'node/node.html'
        });

    $urlRouterProvider.otherwise("/");
});

/** Node Controller */

cvApp.controller('NodeController', ['NodeService', 'nodeData', function(NodeService, nodeData){
    var nodeCtrl = this;

    this.nodeData = nodeData;
}]);


cvApp.directive('node', function($compile) {
    return {
        restrict: 'E',
        replace:true,
        templateUrl: 'node/node.html',
        link: function(scope, elm, attrs) {
            for (key in scope.node) {
                var childNode = $compile('<ul><node-tree ng-model="node.'+key+'"></node-tree></ul>')(scope)
                elm.append(childNode);
            }
        }
    };
});
/**
 * Service to provide Node Data
 */

cvApp.service('NodeService', ['$http', function($http) {
    this.getNode = function (documentName, nodePath) {
        // Remove any leading slash from path
        nodePath = nodePath.replace(/^\//, '');
        return $http.get('/api/' + documentName + nodePath);
    }
}]);

cvApp.directive('nodeTree', function() {
    return {
        templateUrl: 'node/node-tree.html',
        replace: false,
        transclude: true,
        restrict: 'E',
        scope: {
            tree: '=ngModel'
        }
    };
});
/** Document Controller */

cvApp.controller('DocumentController', ['DocumentService', 'documentName', 'documentData', '$state',  function(DocumentService, documentName, documentData, $state){
    var documentCtrl = this;

    this.document = {
        name: documentName,
        data: documentData
    };

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
        }).success(
            function(){
                $state.go('document', {}, {
                    reload: true
                });
            }
        );

    }

}]);

/**
 * Service to provide Document Data
 */

cvApp.service('DocumentService', ['$http', function($http) {

    this.getDocuments = function () {
        return $http.get('/api');
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

//# sourceMappingURL=main.js.map