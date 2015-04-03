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
