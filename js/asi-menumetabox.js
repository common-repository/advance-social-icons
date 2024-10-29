jQuery(document).ready(function($) {
       $('#submit-post-type-archives').click(function(event){
              event.preventDefault();
              msiurl = $('#msi-custom-menu-item-url').val();
              msiitmnam = $('#msi-custom-menu-item-name').val();
              //msiiconimg = $('#msi-custom-menu-item-iconimg').val();
              $('#msi-custom-menu-item-url').parents('p').removeClass('msi-social-warning');
              $('#msi-custom-menu-item-name').parents('p').removeClass('msi-social-warning');
              if( !msiurl || msiurl =='http://') {
                 $('#msi-custom-menu-item-url').parents('p').addClass('msi-social-warning');                
              }
              if( !msiitmnam ) {
                 $('#msi-custom-menu-item-name').parents('p').addClass('msi-social-warning');
              }
              if(!msiurl || msiurl =='http://' || !msiitmnam){
                     return;
              }

              var postTypes = [];
              postTypes.push(msiurl);
              postTypes.push(msiitmnam);
              
               /* Send checked post types with our action, and nonce */
              $.post( ajaxurl, {
                         action: "msi-social-share-links-action",
                         socialicon_nonce: Mysocialiconlinks.nonce,
                         post_types: postTypes,
                    },

                     function( response ) {
                            $('#menu-to-edit').append(response);
                            $('#msi-custom-menu-item-url').val('http://');
                            $('#msi-custom-menu-item-name').val('');
                     }
              );
       })
});