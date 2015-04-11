/** Template Controller */

cvApp.controller('TemplateController', ['$scope', 'TemplateService', '$modalInstance', 'templatePromise', 'nodePath', 'nodeValue', function($scope, TemplateService, $modalInstance, templatePromise, nodePath, nodeValue){
    var templateCtrl = this;

    $scope.nodePath = nodePath;
    // Must convert nodeValue to Json string (ui-ace) only accepts string values
    $scope.nodeValue = angular.toJson(nodeValue, true);
    $scope.templateData = templatePromise.data;
    // Check for the "template" key in the data
    if ($scope.templateData.template){
        $scope.templateHtml = $scope.templateData.template;
    }

    //console.log($scope.nodePath, "NODE PATH");
    //console.log($scope.nodeValue, "NODE VALUE");
    //console.log($scope.templateData, "TEMPLATE DATA");
    //console.log($scope.templateHtml, "TEMPLATE HTML");

    $scope.aceJsonLoaded = function(_editor){
        _editor.$blockScrolling = Infinity;
    };

    $scope.aceHtmlLoaded = function(_editor){
        _editor.$blockScrolling = Infinity;
        // Re-format the html
        $scope.templateHtml = html_beautify($scope.templateHtml);
    };

    $scope.ok = function () {
        $modalInstance.close({templateHtml: $scope.templateHtml, nodeValue: $scope.nodeValue});
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };

}]);
