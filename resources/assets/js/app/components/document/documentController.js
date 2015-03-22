/** Document Controller */

cvApp.controller('DocumentController', ['DocumentService', 'document',  function(DocumentService, document){
    var documentCtrl = this;

    this.document = document;

    /**
     * Create a document with the given name
     *
     * @param documentName
     */
    this.createDocument = function() {
        var documentName = documentCtrl.document.name;
        var documentData = documentCtrl.document.data;
        DocumentService.createDocument(documentName, documentData).success(function(data){
            documentCtrl.document = {
                name: '',
                data: ''
            };
        });
    }

}]);
