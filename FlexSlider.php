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
        register_activation_hook( __FILE__, array($this,'fsInstallDB') );
		add_action('admin_menu', array($this, 'fsIncludeLib'));
		add_action('admin_menu', array($this, 'fsInitDBObj'));
		add_action('admin_menu', array($this, 'fsCreateMenuItems'));
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
		add_menu_page('Flex Slider', 'Flex Slider', 'manage_options', 'slides_listing', array($this, 'fsSliderListing'), '', '66');
		add_submenu_page('slides_listing', 'Add new Slider', 'Add New', 'manage_options', 'add_slides', array($this, 'fsAddSlider'));
	}


	/**
	* Listing Page Admin Menu Link Page
	*/
	public function fsSliderListing()
	{
		$sliders = $this->database->getAllSliders();
		// echo "<pre>";
		// print_r($sliders);
		// echo "</pre>";


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
		require_once(plugin_dir_path( __FILE__ ).'templates/add_slider.php');
	}

}


$plg = new FlexSlider();

