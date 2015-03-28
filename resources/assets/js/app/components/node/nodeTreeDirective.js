cvApp.directive('nodeTree', function() {
    return {
        templateUrl: 'node/node-tree.html',
        transclude: true,
        restrict: 'E',
        scope: {
            node: '='
        }
    };
});