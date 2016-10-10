<?php wp_enqueue_media(); ?>
<div class="wrap">
    <form action="" method="post">
        <div id="icon-users" class="icon32"><br/></div>
        <h2>Add Slider</h2><br/>

        <div id="titlediv">
            <h2 class="sub-title">Slider Title</h2>
            <input type="text" name="slider_name" size="30" value="" id="title" placeholder="Enter Slider Title" spellcheck="true" autocomplete="off">
        </div>

        <div class="slider-type">
            <h2 class="sub-title">Select Slider Type</h2>
            <fieldset><legend class="screen-reader-text"><span>Default Avatar</span></legend>
                <label><input type="radio" name="slider_type" id="default_grid" value="default_grid" checked="checked">Multy Grid</label>
                <label><input type="radio" name="slider_type" id="four_grid" value="four_grid">Four Grid</label>
                <label><input type="radio" name="slider_type" id="two_grid" value="two_grid">Two Grid</label>
                <label><input type="radio" name="slider_type" id="single" value="single">Single</label><br>
            </fieldset>
        </div>

        <h2 class="sub-title">Slides</h2>


        <ul id="sortable" class="slides-wrapper">
            <li class="slides">
                <div class="slide-wrapper">
                    <img src="<?php echo plugins_url(FLEX_DIR_NAME).'/images/default_slide.png'; ?>" class="slide-img" data-img="1">
                    <input type="hidden" name="slide_1" value=""/>
                    <button class="select-img button" type="button" data-id="1" ><span class="dashicons dashicons-camera"></span> Choose Image</button>
                    <a href="javascript:void(0);" class="delete-slide"><span class="dashicons dashicons-trash"></span> Delete</a>
                </div>
            </li>
        </ul>
        <button type="button" class="button add-slide button-large"><span class="dashicons dashicons-plus"></span> Add Slide</button>
        <button type="submit" name="save_slider" class="button button-primary button-large">Save Slider</button>
    </form>
</div>
<script>
    var image_custom_uploader;
    jQuery (document).on('click', '.select-img', function (e) {
        e.preventDefault ();
        var current_button = jQuery (this).attr ('data-id');

        //If the uploader object has already been created, reopen the dialog
    //            if (image_custom_uploader) {
    //                image_custom_uploader.open ();
    //                return;
    //            }

        //Extend the wp.media object
        image_custom_uploader = wp.media.frames.file_frame = wp.media ({
            title   : 'Choose Image',
            button  : {
                text: 'Choose Image'
            },
            multiple: false
        });

        //When a file is selected, grab the URL and set it as the text field's value
        image_custom_uploader.on ('select', function () {
            var attachment    = image_custom_uploader.state ().get ('selection').first ().toJSON ();
            var url;
            url               = attachment['url'];
            var current_image = jQuery ('img[data-img=' + current_button + ']');
            current_image.attr ('src', url);
        });

        //Open the uploader dialog
        image_custom_uploader.open ();

    });

    jQuery(document).ready(function(){
        var sortable = jQuery( "#sortable" );
        jQuery( function() {
            sortable.sortable({
                stop: function(){
                    updateSlidesIndex();
                }
            });
            sortable.disableSelection();
        } );
    });

    jQuery(document).ready(function(){

        // Add Slide Action
        var element = jQuery('.slides-wrapper').html();
        jQuery(document).on('click', '.add-slide', function(){
            jQuery('.slides-wrapper').append(element);
            updateSlidesIndex();
        });


        // Delete Slide Action
        jQuery(document).on('click', '.delete-slide', function(){
            if(jQuery('.delete-slide').length <= 1){
                display_alert('Cannot Delete Last Slide !', 'error');
            }else {
                jQuery (this).closest (".slides").remove ();
                display_alert('Slide Deleted Successfully!', 'success');
            }
        });

    });

    function updateSlidesIndex(){
        var i = 1;
        jQuery(".slides-wrapper li").each(function(){
            jQuery(this).find('input[type=hidden]').attr('name', 'slide_'+i);
            jQuery(this).find('.select-img').attr('data-id', i);
            jQuery(this).find('.slide-img').attr('data-img', i);
            i++;
            var preview = jQuery(this).find('img');
            if(preview.attr('src').length){
                preview.css('opacity', '1');
            }
        });
    }

    function display_alert(msg, type){
        if(type === 'success'){
            jQuery('form').prepend('<div class="updated notice"><p>'+msg+'</p></div>');
        }
        if(type === 'warning'){
            jQuery('form').prepend('<div class="update-nag notice"><p>'+msg+'</p></div>');
        }
        if(type === 'error'){
            jQuery('form').prepend('<div class="error notice"><p>'+msg+'</p></div>');
        }
        setTimeout(function(){
            jQuery('.notice').remove();
        }, 3000);
    }
</script>
