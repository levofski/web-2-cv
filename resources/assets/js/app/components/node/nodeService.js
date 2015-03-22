/**
 * Service to provide Node Data
 */

cvApp.service('NodeData', function($http) {
    this.getNode = function (documentName, nodePath) {
        return $http.get('/api/' + document_name + '/' + nodePath);
    }
});
