/**
 * Service to provide Document Data
 */

cvApp.service('DocumentData', function($http) {

    this.getDocument = function (documentName) {
        return $http.get('/api/' + documentName);
    }

    this.createDocument = function (documentName, documentData) {
        return $http.put('/api/' + documentName, documentData);
    }
});

