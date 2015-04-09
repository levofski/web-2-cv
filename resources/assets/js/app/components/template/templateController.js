/** Template Controller */

cvApp.controller('TemplateController', ['TemplateService', '$modalInstance', function(TemplateService, $modalInstance){
    var templateCtrl = this;

    this.items = items;
    this.selected = {
        item: this.items[0]
    };

    this.ok = function () {
        $modalInstance.close(templateCtrl.selected.item);
    };

    this.cancel = function () {
        $modalInstance.dismiss('cancel');
    };

}]);
