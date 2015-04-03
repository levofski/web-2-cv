/** CV App Module */

var cvApp = angular.module('cvApp', ['ui.router', 'xeditable']);

cvApp.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

cvApp.run(function(editableOptions) {
    editableOptions.theme = 'bs3'; // bootstrap3 theme
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
                    templateUrl: 'document/document.html'
                },
                'name@document.view': {
                    templateUrl: 'document/document-view-name.html',
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
        }).state('document.edit', {
            url: ':document_name/edit',
            views: {
                '': {
                    templateUrl: 'document/document.html'
                },
                'name@document.edit': {
                    templateUrl: 'document/document-edit-name.html',
                    controller: 'DocumentController',
                    controllerAs : 'documentCtrl'
                },
                'data@document.edit': {
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
        });

    $urlRouterProvider.otherwise("/");
});

/** Document Controller */

cvApp.controller('DocumentController', ['DocumentService', 'documentName', 'documentData', '$state', 'editableOptions', function(DocumentService, documentName, documentData, $state, editableOptions){
    var documentCtrl = this;

    // Set the editing flag based on current state
    this.editing = $state.current.name == 'document.edit';

    // Disable xeditable activation if we are not editing
    if (this.editing){
        editableOptions.activationEvent = 'click';
    } else {
        editableOptions.activationEvent = 'none';
    }

    this.document = {
        name: documentName,
        data: documentData
    };

    /**
     * Start editing the document
     */
    this.startEditing = function() {
        $state.go('document.edit', {document_name: documentName}, {
            reload: true
        });
    }

    /**
     * Stop editing the document
     */
    this.stopEditing = function() {
        $state.go('document.view', {document_name: documentName}, {
            reload: true
        });
    }

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

/** Editable Controller */

cvApp.controller('EditableController', [function(){
    var editableCtrl = this;
}]);

cvApp.directive('editable', ['$state',function($state) {
    return {
        restrict: 'E',
        controller: 'EditableController',
        controllerAs: 'editableCtrl',
        templateUrl: function(elem, attrs){
            // If we are not editing, use the noedit template
            var type = 'noedit';
            if ($state.current.name == 'document.edit') {
                // If we are editing, the default type is text
                type = 'text';
                if (typeof attrs.type != 'undefined') {
                    type = attrs.type;
                }
            }
            return 'editable/editable-'+type+'.html';
        },
        link: {
            pre:function($scope, elm, attrs) {
                $scope.fieldKey = attrs.fieldKey;
            }
        }
    };
}]);
cvApp.directive('nodeChild', function() {
    return {
        templateUrl: 'node/node-child.html',
        transclude: true,
        replace: true,
        restrict: 'E'
    };
});
/** Node Controller */

cvApp.controller('NodeController', ['NodeService', 'nodeData', function(NodeService, nodeData){
    var nodeCtrl = this;

    this.nodeData = nodeData;
}]);


cvApp.directive('node', ['$compile', '$templateCache', function($compile, $templateCache) {
    return {
        replace: true,
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
                // Try the exact path
                if ($templateCache.get(this.nodePath)){
                    return this.nodePath;
                }
                // If the path ends with a number, try the default ("_")
                var defaultPath = this.nodePath.replace(/\/\d+$/, '/_');
                if (defaultPath != this.nodePath && $templateCache.get(defaultPath)){
                    return defaultPath;
                }
                return 'node/node.html';
            };
            // Assign helper functions
            $scope.isNumber = angular.isNumber;
            $scope.isCollection = function(item){
                return angular.isArray(item) || angular.isObject(item);
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
        replace: true,
        restrict: 'E',
        scope: {
            node: '=',
            nodePath: '@',
            editing: '='
        }
    };
});
//# sourceMappingURL=main.js.map