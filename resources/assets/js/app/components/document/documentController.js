/** Document Controller */

cvApp.controller('DocumentController', ['DocumentService', 'documentName', 'documentData', '$state', 'editableOptions', function(DocumentService, documentName, documentData, $state, editableOptions){
    var documentCtrl = this;

    // Set the editing flag based on current state
    this.editing = $state.current.name == 'documents.document.edit';

    // Disable xeditable activation if we are not editing
    if (this.editing){
        editableOptions.activationEvent = 'click';
    } else {
        editableOptions.activationEvent = 'none';
    }

    this.document = {
        name: documentName,
        data: documentData
    };

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
                $state.go('documents', {}, {
                    reload: true
                });
            }
        );

    }

    this.items = ['item1', 'item2', 'item3'];

    /**
     * Open a modal to edit the passed template
     *
     * @param path
     */

    this.openTemplateModal = function (path) {
        var modalInstance = $modal.open({
            templateUrl: 'template/modal.html',
            controller: 'TemplateController',
            resolve: {
                items: function () {
                    return documentCtrl.items;
                }
            }
        });
        modalInstance.result.then(function (selectedItem) {
            documentCtrl.selected = selectedItem;
        });
    };

}]);
