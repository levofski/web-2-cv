
cvApp.directive('node', ['$compile', '$templateCache', function($compile, $templateCache) {
    return {
        restrict: 'E',
        template: '<div ng-include="getTemplateUrl()"></div>',
        link: function($scope, elm) {
            var grandparentNodePath = $scope.$parent.$parent.nodePath;
            if (typeof grandparentNodePath == 'undefined'){
                grandparentNodePath = '';
            }
            $scope.nodePath = grandparentNodePath + '/' + $scope.nodeKey;
            // Define dynamic template function
            $scope.getTemplateUrl = function(){
                // Try the exact path
                if ($templateCache.get(this.nodePath)){
                    return this.nodePath;
                }
                // If the path ends with a number, try the default ("_")
                var defaultPath = this.nodePath.replace(/\/\d+$/, '/_');
                if (defaultPath != this.nodePath && $templateCache.get(defaultPath)){
                    return defaultPath;
                }
                return 'node/node.html';
            };
            // Assign helper functions
            $scope.isNumber = angular.isNumber;
            $scope.isCollection = function(item){
                return angular.isArray(item) || angular.isObject(item);
            }
        }
    };
}]);