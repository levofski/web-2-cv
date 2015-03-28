cvApp.directive('nodeChild', function() {
    return {
        templateUrl: 'node/node-child.html',
        transclude: true,
        restrict: 'E'
    };
});