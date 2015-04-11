/** Template Controller */

cvApp.controller('TemplateController', ['$scope', 'TemplateService', '$modalInstance', 'templatePromise', 'nodePath', function($scope, TemplateService, $modalInstance, templatePromise, nodePath){
    var templateCtrl = this;

    $scope.nodePath = nodePath;
    $scope.templateData = templatePromise.data;
    // Check for the "template" key in the data
    if ($scope.templateData.template){
        $scope.templateHtml = $scope.templateData.template;
    }

    //console.log($scope.nodePath, "NODE PATH");
    //console.log($scope.templateData, "TEMPLATE DATA");
    //console.log($scope.templateHtml, "TEMPLATE HTML");

    $scope.aceLoaded = function(_editor){
        _editor.$blockScrolling = Infinity;
        // Re-format the html
        $scope.templateHtml = html_beautify($scope.templateHtml);
    };

    $scope.ok = function () {
        $modalInstance.close($scope.templateHtml);
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };

}]);
