/** Template Controller */

cvApp.controller('TemplateController', ['TemplateService', 'templateName', 'templateData', function(TemplateService, templateName, templateData){
    var templateCtrl = this;

    this.template = {
        name: templateName,
        data: templateData
    };

}]);
