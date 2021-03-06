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
