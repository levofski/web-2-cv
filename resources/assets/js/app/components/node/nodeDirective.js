
cvApp.directive('node', function($compile) {
    return {
        restrict: 'E',
        replace:true,
        templateUrl: 'node/node.html',
        link: function(scope, elm, attrs) {
            for (key in scope.node) {
                var childNode = $compile('<ul><node-tree ng-model="node.'+key+'"></node-tree></ul>')(scope)
                elm.append(childNode);
            }
        }
    };
});