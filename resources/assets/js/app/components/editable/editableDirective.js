cvApp.directive('editable', ['$state',function($state) {
    return {
        restrict: 'E',
        controller: 'EditableController',
        controllerAs: 'editableCtrl',
        templateUrl: function(elem, attrs){
            // If we are not editing, use the noedit template
            var type = 'noedit';
            if ($state.current.name == 'documents.document.edit') {
                // If we are editing, the default type is text
                type = 'text';
                if (typeof attrs.type != 'undefined') {
                    type = attrs.type;
                }
            }
            return 'editable/editable-'+type+'.html';
        },
        link: {
            pre:function($scope, elm, attrs) {
                $scope.fieldKey = attrs.fieldKey;
            }
        }
    };
}]);