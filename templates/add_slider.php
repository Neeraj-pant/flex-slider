<?php wp_enqueue_media(); ?>
<div class="wrap">
    <div id="icon-users" class="icon32"><br/></div>
    <h2>Add Slides</h2><br/>

    <div id="titlediv">
        <input type="text" name="slider_name" size="30" value="" id="title" placeholder="Enter Slider Title" spellcheck="true" autocomplete="off">
    </div>

    <h2 class="sub-title">Slides</h2>

    <div class="">
        <img src="" width="230px" class="slide-img">
        <input class="select-img button" type="button" value="Choose Image"/>
    </div>


    <ul id="sortable">
        <li class="ui-state-default"><span class=""></span>Item 1</li>
        <li class="ui-state-default"><span class=""></span>Item 2</li>
        <li class="ui-state-default"><span class=""></span>Item 3</li>
        <li class="ui-state-default"><span class=""></span>Item 4</li>
        <li class="ui-state-default"><span class=""></span>Item 5</li>
        <li class="ui-state-default"><span class=""></span>Item 6</li>
        <li class="ui-state-default"><span class=""></span>Item 7</li>
    </ul>

</div>
<script>

    var image_custom_uploader;
    jQuery ('.select-img').click (function (e) {
        e.preventDefault ();

        //If the uploader object has already been created, reopen the dialog
        if (image_custom_uploader) {
            image_custom_uploader.open ();
            return;
        }

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
            attachment = image_custom_uploader.state ().get ('selection').first ().toJSON ();
            var url    = '';
            url        = attachment['url'];
            jQuery ('.slide-img').attr ('src', url);
        });

        //Open the uploader dialog
        image_custom_uploader.open ();
    });

    jQuery(document).ready(function(){
        jQuery( function() {
            jQuery( "#sortable" ).sortable();
            jQuery( "#sortable" ).disableSelection();
        } );
    });
</script>
