/**
 * Service to provide Template Data
 */

cvApp.service('TemplateService', ['$http', '$templateCache', function($http, $templateCache) {
    var templateService = this;

    this.getTemplate = function (templateName) {
        return $http.get('/api/' + templateName);
    }

    this.createTemplate = function (templateName, templateData) {
        return $http.put('/api/' + templateName, templateData);
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
                    templateService.preloadCache(val, String(path) + '/' + String(key));
                }
            });
        }
    }
}]);

