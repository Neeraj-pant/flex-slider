<?php wp_enqueue_media();

$is_edit = false;
$name = 'save_slider';
$action = 'admin.php?page=add_slides&noheader=true';
$checked['single'] = $checked['multi_grid'] = $checked['four_grid'] = $checked['two_grid'] = '';
if (isset($slider_data) && !empty($slider_data)) {
    $is_edit = true;
    $checked[$slider_data[0]->slider_type] = 'checked';
    $name = 'update_slider';
    $action = 'admin.php?page=slides_listing';
}

?>
<div class="wrap">
    <form action="<?php echo admin_url($action); ?>" method="post" id="add_slide_form">
        <?php if($is_edit): ?>
            <input type="hidden" name="slider_id" value="<?php echo $slider_data[0]->slider_id; ?>">
        <?php endif; ?>
        <div id="icon-users" class="icon32"><br/></div>
        <h2><?php $is_edit ? _e('Edit Slider') : _e('Add Slider'); ?></h2><br/>

        <div id="titlediv">
            <input type="text" name="slider_name" value="<?php echo ($is_edit) ? $slider_data[0]->slider_name : ''; ?>"
                   size="30" id="title" placeholder="<?php _e('Enter Slider Title'); ?>" spellcheck="true"
                   autocomplete="off">
        </div>

        <div class="slider-type">
            <h2 class="sub-title"><?php _e('Select Slider Type'); ?></h2>
            <fieldset>
                <label><input type="radio" name="slider_type" id="single" value="single"
                              checked="checked" <?php echo $checked['single']; ?>><?php _e('Single'); ?></label>
                <label><input type="radio" name="slider_type" id="multi_grid"
                              value="multi_grid" <?php echo $checked['multi_grid']; ?>><?php _e('Multi Grid'); ?></label>
                <label><input type="radio" name="slider_type" id="four_grid"
                              value="four_grid" <?php echo $checked['four_grid']; ?>><?php _e('Four Grid'); ?>
                </label>
                <label><input type="radio" name="slider_type" id="two_grid"
                              value="two_grid" <?php echo $checked['two_grid']; ?>><?php _e('Two Grid'); ?>
                </label><br>
            </fieldset>
        </div>


        <h2 class="sub-title"><?php _e('Slides'); ?></h2>

        <ul id="sortable" class="slides-wrapper">
            <?php if($is_edit):
                $i = 1;
                foreach($slider_data as $slider): ?>

                    <li class="slides">
                        <div class="slide-wrapper">
                            <img src="<?php echo (!empty($slider->media))? $slider->media : plugins_url(FLEX_DIR_NAME) . '/images/default.png'; ?>" class="slide-img"
                                 data-img="<?php echo $i; ?>">
                            <input type="hidden" name="<?php echo 'slider_data_'.$i; ?>" value="<?php echo $slider->media_id; ?>"/>
                            <button class="select-img button button-primary" type="button" data-id="<?php echo $i; ?>"><span
                                    class="dashicons dashicons-camera"></span> <?php _e('Choose Image'); ?></button>
                            <a href="javascript:void(0);" class="delete-slide button-primary"><span
                                    class="dashicons dashicons-trash"></span></a>
                        </div>
                    </li>
                <?php $i++; endforeach; ?>
            <?php else: ?>
                <li class="slides">
                    <div class="slide-wrapper">
                        <img src="<?php echo plugins_url(FLEX_DIR_NAME) . '/images/default.png'; ?>" class="slide-img"
                             data-img="1">
                        <input type="hidden" name="slider_data_1" value=""/>
                        <button class="select-img button button-primary" type="button" data-id="1"><span
                                class="dashicons dashicons-camera"></span> <?php _e('Choose Image'); ?></button>
                        <a href="javascript:void(0);" class="delete-slide button-primary"><span
                                class="dashicons dashicons-trash"></span></a>
                    </div>
                </li>
            <?php endif; ?>
        </ul>
        <button type="button" class="button add-slide button-large"><span
                class="dashicons dashicons-plus"></span> <?php _e('Add Slide'); ?></button>
        <button type="submit" name="<?php echo $name; ?>" class="button button-primary button-large"
                value="save_slide"><?php _e('Save Slider'); ?></button>
    </form>
    <div id="slider-dummy" style="display: none">
        <li class="slides">
            <div class="slide-wrapper">
                <img src="<?php echo plugins_url(FLEX_DIR_NAME) . '/images/default.png'; ?>" class="slide-img"
                     data-img="1">
                <input type="hidden" name="slider_data_1" value=""/>
                <button class="select-img button button-primary" type="button" data-id="1"><span
                        class="dashicons dashicons-camera"></span> <?php _e('Choose Image'); ?></button>
                <a href="javascript:void(0);" class="delete-slide button-primary"><span
                        class="dashicons dashicons-trash"></span></a>
            </div>
        </li>
    </div>
</div>
<script>

</script>
