var image_custom_uploader;
jQuery(document).on('click', '.select-img', function (e) 
{
    e.preventDefault();
    var current_button = jQuery(this).attr('data-id');

    //If the uploader object has already been created, reopen the dialog
    //            if (image_custom_uploader) {
    //                image_custom_uploader.open ();
    //                return;
    //            }

    //Extend the wp.media object
    image_custom_uploader = wp.media.frames.file_frame = wp.media(
    {
        title: 'Choose Image',
        button: 
        {
            text: 'Choose Image'
        },
        multiple: false
    });

    //When a file is selected, grab the URL and set it as the text field's value
    image_custom_uploader.on('select', function () 
    {
        var attachment = image_custom_uploader.state().get('selection').first().toJSON();
        var url;
        url = attachment['url'];
        var current_image = jQuery('img[data-img=' + current_button + ']');
        current_image.attr('src', url);
        jQuery("input[name=slider_data_" + current_button + "]").val(attachment['id']);
    });

    //Open the uploader dialog
    image_custom_uploader.open();

});




jQuery(document).ready(function () 
{
    var sortable = jQuery("#sortable");
    jQuery(function () 
    {
        sortable.sortable(
        {
            stop: function () 
            {
                updateSlidesIndex();
            }
        });
        sortable.disableSelection();
    });
});



jQuery(document).ready(function () 
{

    // Get initial slide html
    var element = jQuery('#slider-dummy').html();

    // Get Slide Type and add Slides.
    var slider_type = jQuery('input[name = slider_type]');
    var type_val = slider_type.val();
    getSliderByType(type_val, element);




    // Add Slide Action
    jQuery(document).on('click', '.add-slide', function () 
    {
        jQuery('.slides-wrapper').append(element);
        updateSlidesIndex();
    });




    // Change Slide Type action
    jQuery(document).on('change', 'input[name=slider_type]', function () 
    {
        getSliderByType(jQuery(this).val(), element);
    });




    // Delete Slide Action
    jQuery(document).on('click', '.delete-slide', function ()
    {
        var total_slides = jQuery('.delete-slide').length;
        if (total_slides <= 1) 
        {
            display_alert('Cannot Delete Slide !', 'error');
        } 
        else 
        {
            jQuery(this).closest(".slides").remove();
            display_alert('Slide Deleted Successfully!', 'success');
        }
    });




    // Validate form on submit
    jQuery(document).on('submit', '#add_slide_form', function () 
    {
        var slider_name = jQuery('#title').val();
        if (slider_name == '' || slider_name == null) 
        {
            display_alert('Please Enter Slider Name!', 'error');
            return false;
        } 
        else 
        {
            return true;
        }
    });
});




function updateSlidesIndex() 
{
    var i = 1;
    jQuery(".slides-wrapper li").each(function () 
    {
        jQuery(this).find('input[type=hidden]').attr('name', 'slider_data_' + i);
        jQuery(this).find('.select-img').attr('data-id', i);
        jQuery(this).find('.slide-img').attr('data-img', i);
        i++;
        var preview = jQuery(this).find('img');
        if (preview.attr('src').length) 
        {
            preview.css('opacity', '1');
        }
    });
}



function display_alert(msg, type) 
{
    jQuery('.notice').remove();
    if (type === 'success') 
    {
        jQuery('.wrap').prepend('<div class="updated notice is-dismissible"><p>' + msg + '</p></div>');
    }
    else if (type === 'warning') 
    {
        jQuery('.wrap').prepend('<div class="update-nag notice is-dismissible"><p>' + msg + '</p></div>');
    }
    else if (type === 'error') 
    {
        jQuery('.wrap').prepend('<div class="error notice is-dismissible"><p>' + msg + '</p></div>');
    }
    //setTimeout(function () {
    //    jQuery('.notice').remove();
    //}, 5000);
}



function getSliderByType(type_val, element) 
{
    var default_slides = 0;
    var current_slides = jQuery('.slides').length;
    switch (type_val) 
    {
        case 'multi_grid':
            if (current_slides < 5) 
            {
                default_slides = 5;
            }
            break;
        case 'four_grid':
            if (current_slides < 4) 
            {
                default_slides = 4;
            }
            break;
        case 'two_grid':
            if (current_slides < 2) 
            {
                default_slides = 2;
            }
            break;
    }
    if (default_slides > 0) 
    {
        for (var i = current_slides; i < default_slides; i++) 
        {
            jQuery('.slides-wrapper').append(element);
        }
        updateSlidesIndex();
    }
}
