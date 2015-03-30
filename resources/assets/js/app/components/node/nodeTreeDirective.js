cvApp.directive('nodeTree', function() {
    return {
        templateUrl: 'node/node-tree.html',
        transclude: true,
        replace: true,
        restrict: 'E',
        scope: {
            node: '=',
            nodePath: '@',
            editing: '='
        }
    };
});