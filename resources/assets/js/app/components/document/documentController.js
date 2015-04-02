/** Document Controller */

cvApp.controller('DocumentController', ['DocumentService', 'documentName', 'documentData', '$state',  function(DocumentService, documentName, documentData, $state){
    var documentCtrl = this;

    this.editing = false;

    this.document = {
        name: documentName,
        data: documentData
    };

    /**
     * Start editing the document
     */
    this.startEditing = function() {
        this.editing = true;
        this.reloadViews();
    }

    /**
     * Stop editing the document
     */
    this.stopEditing = function() {
        this.editing = false;
        this.reloadViews();
    }

    /**
     * Reload views
     */
    this.reloadViews = function() {
        // Reload only child views
        var params = angular.copy($state.params);
        console.log(params, "PARAMS");
        // do some tricks to not change URL
        params.editing = params.editing === null ? "" : null;
        // go to the same state but without reload : true
        console.log(params, "PARAMS");
        $state.go($state.current, params, { reload: false, inherit: true, notify: true });
    }

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
        }).success(
            function(){
                $state.go('document', {}, {
                    reload: true
                });
            }
        );

    }

}]);
