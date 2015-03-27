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
        // To start off, set the path to en empty string, and add the node-child template to the cache
        if (typeof path == 'undefined'){
            path = '';
            $http.get('node/node-child.html').success(function(data){
                $templateCache.put('node/node-child.html', data);
            });
        }
        if( typeof jsonData == "object" ) {
            $.each(jsonData, function(key,val) {
                // if the key is template, add the value to the cache at this path
                if (key == 'template'){
                    $templateCache.put(path, val);
                } else {
                    documentService.preloadCache(val, String(path) + '/' + String(key));
                }
            });
        }
    }
}]);

