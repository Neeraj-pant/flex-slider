<?php


namespace FledSlider;

/**
 * Install bd and init classes
 */
class InstallDB {

    public function __construct(){
        $this->initTables();
    }


    /**
    * Create DB Tables if not exists
    */
    private function initTables(){
        global $wpdb, $table_prefix;

        $charset_collate = $wpdb->get_charset_collate();

        $sql = array(
            'slider_table' => " "
                ." CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."fl_sliders ( "
                ." slider_id INT NOT NULL AUTO_INCREMENT, "
                ." slider_name varchar(55) NOT NULL,"
                ." slider_status INT NOT NULL DEFAULT 1,"
                ." created_on TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,"
                ." modified_on TIMESTAMP NOT NULL,"
                ." PRIMARY KEY (slider_id)"
                ." ) $charset_collate;",
            'slide_table' => " "
                ." CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."fl_slider_slides ( "
                ." slide_id INT NOT NULL AUTO_INCREMENT, "
                ." slider_id INT NOT NULL, "
                ." slider_media_id varchar(55) NOT NULL,"
                ." created_on TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,"
                ." modified_on TIMESTAMP NOT NULL,"
                ." PRIMARY KEY (slide_id)"
                ." ) $charset_collate;",
            'slide_meta' => " "
                ." CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."fl_slider_meta ( "
                ." meta_id INT NOT NULL AUTO_INCREMENT, "
                ." slider_id INT NOT NULL, "
                ." slider_meta_name varchar(55) NOT NULL,"
                ." slider_meta_value varchar(255) NOT NULL,"
                ." created_on TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,"
                ." modified_on TIMESTAMP NOT NULL,"
                ." PRIMARY KEY (meta_id)"
                ." ) $charset_collate;"
        );

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        foreach($sql as $table){
            dbDelta( $table );
        }
    }
}

