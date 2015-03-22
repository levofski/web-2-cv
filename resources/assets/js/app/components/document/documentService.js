/**
 * Service to provide Document Data
 */

cvApp.service('DocumentData', function($http) {
    this.getDocument = function (document_name) { return $http.get('/api/' + document_name); }
    this.createDocument = function (document_name) { return $http.put('/api/' + document_name, {}); }
});

