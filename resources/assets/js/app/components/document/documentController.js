/** Document Controller */

cvApp.controller('DocumentController', ['DocumentData', function(DocumentData){
    var documentCtrl = this;

    this.newDocument = {
        name: '',
        data: ''
    };

    /**
     * View a document with the given name
     *
     * @param documentName
     */
    this.createDocument = function() {
        var documentName = documentCtrl.newDocument.name;
        var documentData = documentCtrl.newDocument.data;
        DocumentData.createDocument(documentName, documentData).success(function(data){
            documentCtrl.newDocument = {
                name: '',
                data: ''
            };
        });
    }

    /**
     * View a document with the given name
     *
     * @param documentName
     */
    this.viewDocument = function(documentName) {
        DocumentData.getDocument(documentName).success(function(data){
            documentCtrl.document = data;
        });
    }


}]);
