/**
 * Service to provide Document Data
 */

cvApp.service('DocumentService', ['$http', '$templateCache', function($http, $templateCache) {
    var documentService = this;

    this.getDocuments = function () {
        return $http.get('/api');
    }

    this.getDocument = function (documentName) {
        return $http.get('/api/' + documentName);
    }

    this.createDocument = function (documentName, documentData) {
        return $http.put('/api/' + documentName, documentData);
    }

    this.preloadCache = function(jsonData, path) {
        if (typeof path == 'undefined'){
            path = '';
        }
        if( typeof jsonData == "object" ) {
            $.each(jsonData, function(key,val) {
                documentService.preloadCache(val, String(path) + '/' + String(key));
            });
        }
        else {
            // jsonData is a string, add it to the cache at this path
            $templateCache.put(path, jsonData);
        }
    }
}]);

