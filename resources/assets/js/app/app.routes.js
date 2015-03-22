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
