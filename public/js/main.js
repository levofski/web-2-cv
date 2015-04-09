/** CV App Module */

var cvApp = angular.module('cvApp', ['ui.router', 'ui.bootstrap', 'xeditable']);

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
        .state('documents', {
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
        .state('documents.new', {
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
        .state('documents.document', {
            abstract: true,
            url: ':document_name',
            templateUrl: 'document/document.html',
            resolve: {
                documentName: function($stateParams){
                    return $stateParams.document_name;
                },
                documentDataPromise: function($stateParams, DocumentService){
                    return DocumentService.getDocument($stateParams.document_name);
                },
                templatePromise: function($stateParams, TemplateService){
                    return TemplateService.getTemplate($stateParams.document_name+'-templates');
                },
                documentData: function(documentDataPromise, templatePromise, TemplateService){
                    // Preload the template cache with the templates for this document
                    var templates = templatePromise.data;
                    TemplateService.preloadCache(templates);
                    return documentDataPromise.data;
                }
            }
        })
        .state('documents.document.view', {
            url: '/view',
            views: {
                'name@documents.document': {
                    templateUrl: 'document/document-view-name.html',
                    controller: 'DocumentController',
                    controllerAs : 'documentCtrl'
                },
                'data@documents.document': {
                    templateUrl: 'document/document-data.html',
                    controller: 'DocumentController',
                    controllerAs : 'documentCtrl'
                }
            }
        }).state('documents.document.edit', {
            url: '/edit',
            views: {
                'name@documents.document': {
                    templateUrl: 'document/document-edit-name.html',
                    controller: 'DocumentController',
                    controllerAs : 'documentCtrl'
                },
                'data@documents.document': {
                    templateUrl: 'document/document-data.html',
                    controller: 'DocumentController',
                    controllerAs : 'documentCtrl'
                }
            }
        });

    $urlRouterProvider.otherwise("/");
});

/** Document Controller */

cvApp.controller('DocumentController', ['DocumentService', 'documentName', 'documentData', '$state', 'editableOptions', function(DocumentService, documentName, documentData, $state, editableOptions){
    var documentCtrl = this;

    // Set the editing flag based on current state
    this.editing = $state.current.name == 'documents.document.edit';

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
                $state.go('documents', {}, {
                    reload: true
                });
            }
        );

    }

    this.items = ['item1', 'item2', 'item3'];

    /**
     * Open a modal to edit the passed template
     *
     * @param path
     */

    this.openTemplateModal = function (path) {
        var modalInstance = $modal.open({
            templateUrl: 'template/modal.html',
            controller: 'TemplateController',
            resolve: {
                items: function () {
                    return documentCtrl.items;
                }
            }
        });
        modalInstance.result.then(function (selectedItem) {
            documentCtrl.selected = selectedItem;
        });
    };

}]);

/**
 * Service to provide Document Data
 */

cvApp.service('DocumentService', ['$http', function($http) {
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
            if ($state.current.name == 'documents.document.edit') {
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
/** Template Controller */

cvApp.controller('TemplateController', ['TemplateService', '$modalInstance', function(TemplateService, $modalInstance){
    var templateCtrl = this;

    this.items = items;
    this.selected = {
        item: this.items[0]
    };

    this.ok = function () {
        $modalInstance.close(templateCtrl.selected.item);
    };

    this.cancel = function () {
        $modalInstance.dismiss('cancel');
    };

}]);

/**
 * Service to provide Template Data
 */

cvApp.service('TemplateService', ['$http', '$templateCache', function($http, $templateCache) {
    var templateService = this;

    this.getTemplate = function (templateName) {
        return $http.get('/api/' + templateName);
    }

    this.createTemplate = function (templateName, templateData) {
        return $http.put('/api/' + templateName, templateData);
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
                    templateService.preloadCache(val, String(path) + '/' + String(key));
                }
            });
        }
    }
}]);


//# sourceMappingURL=main.js.map