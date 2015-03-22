/** Angular Routing Config */

cvApp.config( function($routeProvider) {
    $routeProvider
        .when('/new', { controller: 'DocumentController', templateUrl: 'document/new.html' })
        .when('/:document_name', { controller: 'DocumentController', templateUrl: 'document/document.html' })
        .when('/:document_name/:path', { controller: 'NodeController', templateUrl: 'node/node.html' })
        .otherwise({ redirect: '/' });
});
