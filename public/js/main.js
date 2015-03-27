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
                documentTemplatesPromise: function($stateParams, DocumentService){
                    return DocumentService.getDocument($stateParams.document_name+'-templates');
                },
                documentData: function(documentDataPromise, documentTemplatesPromise, DocumentService){
                    // Preload the template cache with the templates for this document
                    var documentTemplates = documentTemplatesPromise.data;
                    DocumentService.preloadCache(documentTemplates);
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

cvApp.service('DocumentService', ['$http', '$templateCache', function($http, $templateCache) {
    var documentService = this;

    this.getDocuments = function () {
        return $http.get('/api');
    }

    this.getDocument = function (documentName) {
        return $http.get('/api/' + documentName);
    }

    this.createDocument = function (documentName, documentData) {
        return $http.put('/api/' + documentName, documentData);
    }

    this.preloadCache = function(jsonData, path) {
        // To start off, set the path to en empty string, and add the node-child template to the cache
        if (typeof path == 'undefined'){
            path = '';
            $http.get('node/node-child.html').success(function(data){
                $templateCache.put('node/node-child.html', data);
            });
        }
        if( typeof jsonData == "object" ) {
            $.each(jsonData, function(key,val) {
                // if the key is template, add the value to the cache at this path
                if (key == 'template'){
                    $templateCache.put(path, val);
                } else {
                    documentService.preloadCache(val, String(path) + '/' + String(key));
                }
            });
        }
    }
}]);


/** Documents Controller */

cvApp.controller('DocumentsController', ['documents',  function(documents){
    var documentsCtrl = this;

    this.documents = documents;

}]);

/** Node Controller */

cvApp.controller('NodeController', ['NodeService', 'nodeData', function(NodeService, nodeData){
    var nodeCtrl = this;

    this.nodeData = nodeData;
}]);


cvApp.directive('node', ['$compile', '$templateCache', function($compile, $templateCache) {
    return {
        restrict: 'E',
        template: '<div ng-include="getTemplateUrl()"></div>',
        link: function($scope, elm) {
            var grandparentNodePath = $scope.$parent.$parent.nodePath;
            if (typeof grandparentNodePath == 'undefined'){
                grandparentNodePath = '';
            }
            $scope.nodePath = grandparentNodePath + '/' + $scope.nodeKey;
            // Define dynamic template function
            $scope.getTemplateUrl = function(){
                if ($templateCache.get(this.nodePath)){
                    return this.nodePath;
                }
                return 'node/node.html';
            };
            // Assign helper functions
            $scope.isNumber = angular.isNumber;
            $scope.isCollection = function(item){
                return angular.isArray(item) || angular.isObject(item);
            }
            // If the value is a collection, append a new tree for it
            if ($scope.isCollection($scope.nodeValue)) {
                var childNode = $compile($templateCache.get('node/node-child.html'))($scope)
                elm.append(childNode);
            }
        }
    };
}]);
/**
 * Service to provide Node Data
 */

cvApp.service('NodeService', ['$http', function($http) {
    this.getNode = function (documentName, nodePath) {
        // Remove any leading slash from path
        nodePath = nodePath.replace(/^\//, '');
        return $http.get('/api/' + documentName + '/' + nodePath);
    }
    this.getNodeTemplate = function (documentName, nodePath) {
        // Remove any leading slash from path
        nodePath = nodePath.replace(/^\//, '');
        return $http.get('/api/' + documentName + '-templates/' + nodePath);
    }
}]);

cvApp.directive('nodeTree', function() {
    return {
        templateUrl: 'node/node-tree.html',
        transclude: true,
        restrict: 'E',
        scope: {
            tree: '=ngModel'
        }
    };
});
//# sourceMappingURL=main.js.map