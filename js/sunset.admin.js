jQuery(document).ready(function($){
    var mediaUploader;

    $( '#upload-button' ).on('click', function(e){
        // the e parameter is all the data from the button which is all classes and ids...
        // prevent the default behavior of this button
        e.preventDefault();
        if ( mediaUploader ){
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media.frames.file_frame = wp.media({
            // wp.media.frames.file_frame this is to access the different levels of the media uploader of wordpress
            // now we can customize our media uploader
            title : 'Choose  Profile Picture',
            button: {
                text: 'Choose Picture'
            },
            multiple: false // prevents user to choose multiple pictures
        });
        //if image is selected get the img url
        mediaUploader.on('select', function(){
            attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#profile-picture').val(attachment.url);
            // like this the user can preview the img before clicking the confirm btn to save changes
            $('#profile-picture-preview').css('background-image', 'url(' + attachment.url + ')');
        });
        
        mediaUploader.open();
    });

    $( '#remove-button' ).on( 'click', function(e){
        // to prevent the default behavior of the button, like submitting the form
        e.preventDefault();
        var answer = confirm( 'are you sure you want to delete your Profile Picture?' );
        if ( answer == true ){
            $('#profile-picture').val('');
            $('.sunset-general-form').submit();
        }
        return;
    });
});