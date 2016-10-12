<?php

/*
Plugin Name: Flex Slider
Plugin URI: https://github.com/Neeraj-pant/flex-slider
Description: Customizable slider From grids to single
Version: 1.0
Author: Neeraj Pant
Author URI: https://github.com/Neeraj-pant
License: GPL-3.0
License URI: https://www.gnu.org/licenses/gpl.txt
*/

// namespace FlexSlider;
// use FlexSlider\Lib;

class FlexSlider
{
	private $database;

	function __construct()
	{
        add_action('admin_init', array($this, 'fsInit'));
        register_activation_hook( __FILE__, array($this,'fsInstallDB') );
		add_action('admin_init', array($this, 'fsIncludeLib'));
		add_action('admin_init', array($this, 'fsInitDBObj'));
		add_action('admin_menu', array($this, 'fsCreateMenuItems'));
        add_action('admin_enqueue_scripts', array($this, 'fsIncludeStyleSheet'));
    }





    /*
     * Initilize Slider Configuration
     */
    public function fsInit()
    {
        defined('FLEX_VERSION')             OR define('FLEX_VERSION', 1.0);
        defined('FLEX_DIR_NAME')            OR define('FLEX_DIR_NAME', basename(__DIR__) );
        defined('FLEX_DUMMY_SLIDE_IMAGE')   OR define('FLEX_DUMMY_SLIDE_IMAGE', plugins_url(FLEX_DIR_NAME.'/images/default.png'));
    }





   /**
   * Initialize or create DB tables
   */
  public function fsInstallDB(){
	require_once(plugin_dir_path( __FILE__ ).'lib/InstallDB.php');
	$db_install = new InstallDB();
  }



	
	/**
	* Include Library
	*/
	public function fsIncludeLib()
	{
        include_once(plugin_dir_path( __FILE__ ).'lib/Listing.php');
        include_once(plugin_dir_path( __FILE__ ).'lib/Database.php');
	}





	public function fsInitDBObj(){
		$this->database = new Database();
	}






	/**
	* Creating Admin Menu Items
	*/
	public function fsCreateMenuItems()
	{
		add_menu_page('Flex Slider', __('Flex Slider'), 'manage_options', 'slides_listing', array($this, 'fsSliderListing'), '', '66');
		add_submenu_page('slides_listing', __('Add new Slider'), 'Add New', 'manage_options', 'add_slides', array($this, 'fsAddSlider'));
	}






	/**
	* Listing Page Admin Menu Link Page
	*/
	public function fsSliderListing()
	{
		$sliders = $this->database->getAllSliders();

	    $testListTable = new Listing($sliders);
	    $testListTable->prepare_items();
	    ?>
	    <div class="wrap">
	        <div id="icon-users" class="icon32"><br/></div>
	        <h2>Sliders</h2>
	        <form id="movies-filter" method="get">
	            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
	            <?php $testListTable->display() ?>
	        </form>
	    </div>
		<?php
	}






	/*
	* Add Slides Admin Menu Page
	*/
	public function fsAddSlider()
	{
		if(isset($_POST['save_slider'])){
			$this->fsSaveSlider();
		}
		require_once(plugin_dir_path( __FILE__ ).'templates/add_slider.php');
	}





	/*
	* Save Slider and Slides
	*/
	private function fsSaveSlider()
	{
		$slider['slider_name'] = $_POST['slider_name'];
		$slider['slider_type'] = $_POST['slider_type'];
		$slider_id = $this->database->saveSlider($slider);
		if(!$slider_id)
		{
            ?>
            <script type="text/javascript">display_alert(<?php _e( 'Error Occurred, some Sliders might not be Saved!' ); ?>, 'error');</script>
            <?php
		}
		else
		{
			$slides = $_POST;
			unset($slides['slider_name']);
			unset($slides['slider_type']);
			unset($slides['save_slider']);
			$save_slides = $this->database->saveSlides($slides, $slider_id);
            if($save_slides)
            {
                ?>
                <script type="text/javascript">display_alert(<?php _e( 'Slider Saved Successfully!' ); ?>, 'success');</script>
                <?php
            }
		}
	}






    /**
     * Show Slider save message
     */
    public function fsSlideSaveNoticeSuccess()
    {
        ?>
            <div class="notice notice-success is-dismissible">
                <p><?php _e( 'Slider Saved Successfully!' ); ?></p>
            </div>
        <?php
    }






	/*
	 * Include StyleSheets
	 */
	public function fsIncludeStyleSheet( $hook )
	{
        wp_register_style('flex-slider-style', plugins_url(FLEX_DIR_NAME.'/css/slider_base.css'), false, FLEX_VERSION);
        wp_enqueue_style('flex-slider-style');

    	wp_enqueue_script('flex_elements_js', plugins_url(FLEX_DIR_NAME.'/js/flex_elements.js'), array('jquery-core'), FLEX_VERSION);
	}

}



$flex = new FlexSlider();



function dd($data){
     echo "<pre>";
     print_r($data);
     echo "</pre>";
    die;
}


function d($data){
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}
