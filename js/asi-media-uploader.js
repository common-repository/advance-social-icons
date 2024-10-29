jQuery(document).ready(function ($) {
  // Instantiates the variable that holds the media library frame.
  var meta_image_frame;
  // Runs when the image button is clicked.
  $(document).on('click','.gwts-gwl-imgupload', function (e) {    
    itmid = $(this).attr('id');
    e.preventDefault();
    // If the frame already exists, re-open it.
    if (meta_image_frame) {
      meta_image_frame.open();
      return;
    }

    // Sets up the media library frame
    meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
      title: 'Select images to upload',
      button: {
        text: 'Use this image',
      },
      multiple: false
    });
    // Runs when an image is selected.
    meta_image_frame.on('select', function () {
      var attachments = meta_image_frame.state().get('selection').map( function( attachment ) {
                    attachment.toJSON();
                    return attachment;

            });
          //loop through the array and do things with each attachment
           var i;
           for (i = 0; i < attachments.length; ++i) {
                //sample function 1: add image preview
                $('#gwts-gwl-sortableitem-'+itmid).html(
                    '<div class="gwt-gwlgalleryimg"><img src="' + 
                    attachments[i].attributes.url + '" title="img' + 
                    attachments[i].id + '" ><input type="hidden" icoid="'+attachments[i].id+'" value="'+attachments[i].attributes.url+'"></div>'
                    );  
                $('#edit-menu-item-subtitle-'+itmid).val(attachments[i].attributes.url);
                $('.msi-view-upload-icn-'+itmid).remove();

            }
    });
    // Opens the media library frame.
    meta_image_frame.open();
  });
  
});

