jQuery( function($) {
    var custom_uploader;
    
    $('#widgets-right').on('click', '.upload_image_button', function (e) {
        var that = this;
        e.preventDefault();
        console.log(e);
        console.log(that);
        console.log('click');

        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });

        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $(e.target).siblings('input').val(attachment.id);
            $(e.target).siblings('img').attr('src', attachment.sizes.thumbnail.url);
            console.log(attachment);
        });

        //Open the uploader dialog
        custom_uploader.open();

    });
});