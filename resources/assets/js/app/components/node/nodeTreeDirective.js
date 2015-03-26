cvApp.directive('nodeTree', function() {
    return {
        templateUrl: 'node/node-tree.html',
        replace: false,
        transclude: true,
        restrict: 'E',
        scope: {
            tree: '=ngModel'
        }
    };
});