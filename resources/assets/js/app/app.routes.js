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
                mainModule: {
                    templateUrl: 'document/document-view.html'
                },
                'name': {
                    templateUrl: 'document/document-name.html',
                    controller: 'DocumentController',
                    controllerAs : 'documentCtrl'
                },
                'data': {
                    templateUrl: 'node/node.html',
                    controller: 'NodeController',
                    controllerAs : 'nodeCtrl'
                }
            },
            resolve: {
                documentName: function($stateParams){
                    return $stateParams.document_name;
                },
                documentData: function(){
                    return '';
                },
                nodeData: function($stateParams, NodeService){
                    return NodeService.getNode($stateParams.document_name, '/');
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
