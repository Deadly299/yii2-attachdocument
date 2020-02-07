if (!!!deadly299) {
    var deadly299 = {};
}

deadly299.attachDocument = {
    btnRemoveDocument: '[data-role=remove-document-deadly299]',

    init: function () {
        console.log('work');
        $(document).on('click', deadly299.attachDocument.btnRemoveDocument, this.removeFile);
    },

    removeFile: function () {
        if (confirm('Удалить?')) {
            var self = this,
                url = $(this).data('action');

            $.post({
                url: url,
                data: {},
                success: function (response) {
                    $(self).parent().hide();
                },
                error: function (response) {
                    alert(response);
                }
            });
        }

    }
};
deadly299.attachDocument.init();