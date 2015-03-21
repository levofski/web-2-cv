/** Angular Routing Config */

cvApp.config( function($routeProvider) {
    $routeProvider
        .when('/:document_name', { controller: 'DocumentController', templateUrl: './document/document.html' })
        .when('/:document_name/:path', { controller: 'DocumentController', templateUrl: './document/node.html' })
        .otherwise({ redirect: '/' });
});
