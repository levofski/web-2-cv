cvApp.directive('nodeTree', ['$modal', '$stateParams', 'TemplateService', function($modal, $stateParams, TemplateService) {
    return {
        templateUrl: 'node/node-tree.html',
        transclude: true,
        replace: true,
        restrict: 'E',
        scope: {
            node: '=',
            nodePath: '@',
            editing: '='
        },
        link: function($scope, elm) {

            /**
             * Open a modal to edit the template
             *
             * @param path
             */
            $scope.openTemplateModal = function (nodePath) {
                var modalInstance = $modal.open({
                    templateUrl: 'template/modal.html',
                    controller: 'TemplateController',
                    resolve: {
                        templatePromise: function($stateParams, TemplateService){
                            return TemplateService.getTemplate($stateParams.document_name+'-templates', nodePath);
                        },
                        nodePath: function(){
                            return nodePath;
                        }
                    }
                });
                modalInstance.result.then(function () {
                    console.log("RESULT");
                });
            };
        }
    }
}]);