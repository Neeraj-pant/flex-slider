<?php wp_enqueue_media(); ?>
<div class="wrap">
    <form action="" method="post" id="add_slide_form">
        <div id="icon-users" class="icon32"><br/></div>
        <h2><?php _e('Add Slider'); ?></h2><br/>

        <div id="titlediv">
            <input type="text" name="slider_name" size="30" value="" id="title" placeholder="<?php _e('Enter Slider Title'); ?>" spellcheck="true" autocomplete="off">
        </div>

        <div class="slider-type">
            <h2 class="sub-title"><?php _e('Select Slider Type'); ?></h2>
            <fieldset>
                <label><input type="radio" name="slider_type" id="single" value="single" checked="checked"><?php _e('Single'); ?></label>
                <label><input type="radio" name="slider_type" id="multi_grid" value="multi_grid"><?php _e('Multi Grid'); ?></label>
                <label><input type="radio" name="slider_type" id="four_grid" value="four_grid"><?php _e('Four Grid'); ?></label>
                <label><input type="radio" name="slider_type" id="two_grid" value="two_grid"><?php _e('Two Grid'); ?></label><br>
            </fieldset>
        </div>

        <h2 class="sub-title"><?php _e('Slides'); ?></h2>


        <ul id="sortable" class="slides-wrapper">
            <li class="slides">
                <div class="slide-wrapper">
                    <img src="<?php echo plugins_url(FLEX_DIR_NAME).'/images/default.png'; ?>" class="slide-img" data-img="1">
                    <input type="hidden" name="slide_1" value="" />
                    <button class="select-img button" type="button" data-id="1" ><span class="dashicons dashicons-camera"></span> <?php _e('Choose Image'); ?></button>
                    <a href="javascript:void(0);" class="delete-slide"><span class="dashicons dashicons-trash"></span></a>
                </div>
            </li>
        </ul>
        <button type="button" class="button add-slide button-large"><span class="dashicons dashicons-plus"></span> <?php _e('Add Slide'); ?></button>
        <button type="submit" name="save_slider" class="button button-primary button-large" value="save_slide"><?php _e('Save Slider'); ?></button>
    </form>
</div>
<script>

</script>
