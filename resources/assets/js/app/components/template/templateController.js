/** Template Controller */

cvApp.controller('TemplateController', ['$scope', 'TemplateService', '$modalInstance', 'templatePromise', 'nodePath', function($scope, TemplateService, $modalInstance, templatePromise, nodePath){
    var templateCtrl = this;

    $scope.nodePath = nodePath;
    $scope.template = templatePromise.data;

    console.log($scope.nodePath, "TEMPLATE");
    console.log($scope.template, "TEMPLATE");

    $scope.ok = function () {
        $modalInstance.close();
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };

}]);
