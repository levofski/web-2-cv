
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
                if ($templateCache.get(this.nodePath)){
                    return this.nodePath;
                }
                return 'node/node.html';
            };
            // Assign helper functions
            $scope.isNumber = angular.isNumber;
            $scope.isCollection = function(item){
                return angular.isArray(item) || angular.isObject(item);
            }
            // If the value is a collection, append a new tree for it
            if ($scope.isCollection($scope.nodeValue)) {
                var childNode = $compile($templateCache.get('node/node-child.html'))($scope)
                elm.append(childNode);
            }
        }
    };
}]);