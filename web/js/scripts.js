if (!!!deadly299) {
    var deadly299 = {};
}

deadly299.upload = {
    file: null,
    fileNameInInput: '.file-caption-name',
    btnClose: '[data-role=close-modal-upload]',
    inputUpload: '[data-role=input-upload-document]',
    inputNameFile: '[data-role=input-name-document]',
    btnUpload: '[data-role=upload-file]',
    btnRenameFile: '[data-role=rename-file-document]',
    btnRemoveFile: '[data-role=remove-file-document]',
    inputNewNameFile: '[data-role=input-new-name-file-document]',

    init: function () {

        $(document).on('change', deadly299.upload.inputUpload, this.initFiles);
        $(document).on('click', deadly299.upload.btnUpload, this.uploadFile);
        $(document).on('click', deadly299.upload.btnClose, this.closeModal);
        $(document).on('click', deadly299.upload.btnRenameFile, this.renameFile);
        $(document).on('click', deadly299.upload.btnRemoveFile, this.removeFile);
    },
    initFiles: function () {
        deadly299.upload.file = this.files;
    },
    uploadFile: function () {
        var data = new FormData(),
            url = $(this).data('action'),
            divResponse = '[data-role=response]',
            modelName = $(deadly299.upload.inputUpload).data('model-name'),
            modelId = $(deadly299.upload.inputUpload).data('model-id'),
            nameDocument = $(deadly299.upload.inputNameFile).val(),
            successMassage = '<p><span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Файл загружен</p>',
            errorMassage = '<p><span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span> При загрузки файла произошла ошибка</p>';



        $.each( deadly299.upload.file, function( key, value ){
            data.append( key, value );
        });
        data.append( 'modelName', modelName );
        data.append( 'modelId', modelId );
        data.append( 'nameDocument', nameDocument );

        $.ajax({
            url: url,
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            type: 'post',
            success: function(response){

                if(response) {
                    $(deadly299.upload.fileNameInInput).text('');
                    $(divResponse).html(successMassage);
                } else {
                    $(divResponse).html(errorMassage);
                }
            }
        });
    },

    closeModal: function () {
        $(deadly299.upload.fileNameInInput).text('');
    },

    renameFile: function () {
        var url = $(deadly299.upload.inputNewNameFile).data('action'),
            id = $(deadly299.upload.inputNewNameFile).data('id'),
            name = $(this).parents('.modal-content').find(deadly299.upload.inputNewNameFile).val();
        if(name != '') {
            $.post({
                url: url,
                data: {name: name, id: id},
                success: function (response) {
                    return true;
                }
            });
        } else {
            return false;
        }
    },
    removeFile: function () {
        var url = $(this).data('action'),
            id = $(this).data('id');

        $.post({
            url: url,
            data: {id: id},
            success: function (response) {
                return true;
            }
        });
    }
};
deadly299.upload.init();