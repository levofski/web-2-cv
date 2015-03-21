/** Document Controller */

cvApp.controller('DocumentController', ['DocumentData', function(DocumentData){
    var documentCtrl = this;
    DocumentData.getDocument('test-document').success(function(data){
        documentCtrl.document = data;
    });

    console.log("DocumentController");
}]);
