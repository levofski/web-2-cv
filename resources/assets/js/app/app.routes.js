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
                document: function(){
                    return {
                        name: '',
                        data: ''
                    };
                }
            }
        })
        .state('document.view', {
            url: ':document_name',
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
            url: ':document_name/:path',
            controller: 'NodeController',
            controllerAs: 'nodeCtrl',
            templateUrl: 'node/node.html'
        });

    $urlRouterProvider.otherwise("/");
});
