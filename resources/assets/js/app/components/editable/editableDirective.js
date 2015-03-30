cvApp.directive('editable', ['$interpolate', function($interpolate) {
    return {
        templateUrl: 'editable/editable.html',
        restrict: 'E',
        controller: 'EditableController',
        controllerAs: 'editableCtrl',
        link: function($scope, elm, attrs) {
            $scope.fieldKey = attrs['fieldKey'];
            $scope.fieldValue = $interpolate("[["+attrs['fieldKey']+"]]")($scope.$parent);
        }
    };
}]);