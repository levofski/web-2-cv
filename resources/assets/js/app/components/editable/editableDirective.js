cvApp.directive('editable', ['$parse', '$interpolate', function($parse, $interpolate) {
    return {
        templateUrl: 'editable/editable.html',
        restrict: 'E',
        controller: 'EditableController',
        controllerAs: 'editableCtrl',
        link: {
            pre:function($scope, elm, attrs) {
                $scope.fieldKey = attrs['fieldKey'];
            }
        }
    };
}]);