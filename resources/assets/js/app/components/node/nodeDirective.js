
cvApp.directive('node', function($compile) {
    return {
        restrict: 'E',
        templateUrl: 'node/node.html',
        link: function(scope, elm, attrs) {
            scope.isNumber = angular.isNumber;
            scope.isCollection = function(item){
                return angular.isArray(item) || angular.isObject(item);
            }
            if (scope.isCollection(scope.nodeValue)) {
                var childNode = $compile('<ul><node-tree ng-model="nodeValue"></node-tree></ul>')(scope)
                elm.append(childNode);
            }
        }
    };
});