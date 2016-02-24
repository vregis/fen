(function(){
    //ckeditor
    //jQuery('textarea').ckeditor();

    //iCheck
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });

    //select2
    $(".select2").select2();

    var editImage = $('#edit-image'),
        imageBox = $('#image_box'),
        thumbs = $('#thumbs');

    $("div#upload").dropzone({ url: "/_root/multiupload"});

    //image-edit
    imageBox.on('click', '.fa-pencil', function(){
        var id = $(this).closest('.ui-sortable-handle').find('img').attr('data-id');
        $.post('/_root/gallery/image-edit/' + id, function(data){
            $('#edit-image').html(data);
            $('input[type="checkbox"].minimal').iCheck({ checkboxClass: 'icheckbox_minimal-blue' });
        });
    });

    //image-remove
    imageBox.on('click', '.fa-trash', function(){
        var item = $(this);
        if(confirm('Вы уверены, что хотите удалить?')){
            var url = $(this).attr('data-url');
            $.post(url, function(){
                item.closest('.ui-sortable-handle').remove();
            });
        }
    });

    //image-save-change
    editImage.on('click', '#edit_image_button', function(e){
        e.preventDefault();
        var form = $(this).closest('#edit-image').find('form');
        $.ajax({
            url: form.attr('action'),
            type: "POST",
            dataType: "json",
            data: form.serialize(),
            success: function(data) {
                editImage.modal('hide');
                imageBox.html(data);
            }
        });
    });

})();