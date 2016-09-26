<?php

/*
Plugin Name: Flex Slider
Plugin URI: https://github.com/Neeraj-pant/flex-slider
Description: Customizable slider to grids or single
Version: 1.0
Author: Neeraj Pant
Author URI: https://github.com/Neeraj-pant
License: GPL-3.0
License URI: https://www.gnu.org/licenses/gpl.txt
*/

namespace FledSlider;

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
	require_once(plugin_dir_path( __FILE__ ).'lib/classes/InstallDB.php');
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
		print_r($sliders);

		$data = array(
            array(
                'ID'        => 1,
                'title'     => '300',
                'total_slides'    => 'R',
                'type'  => 'Zach Snyder'
            ),
            array(
                'ID'        => 2,
                'title'     => 'Eyes Wide Shut',
                'total_slides'    => 'R',
                'type'  => 'Stanley Kubrick'
            ),
            array(
                'ID'        => 3,
                'title'     => 'Moulin Rouge!',
                'total_slides'    => 'PG-13',
                'type'  => 'Baz Luhrman'
            ),
            array(
                'ID'        => 4,
                'title'     => 'Snow White',
                'total_slides'    => 'G',
                'type'  => 'Walt Disney'
            ),
            array(
                'ID'        => 5,
                'title'     => 'Super 8',
                'total_slides'    => 'PG-13',
                'type'  => 'JJ Abrams'
            )
        );


	    $testListTable = new Listing($data);
	    $testListTable->prepare_items();
	    ?>
	    <div class="wrap">
	        <div id="icon-users" class="icon32"><br/></div>
	        <h2>Slides</h2>
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
		echo "sub";
	}
}


$plg = new FlexSlider();



/**
 * Register meta box(es).
 */
function wpdocs_register_meta_boxes() {
    add_meta_box( 'meta-box-id', __( 'My Meta Box', 'textdomain' ), 'wpdocs_my_display_callback', '' );
}
add_action( 'add_meta_boxes', 'wpdocs_register_meta_boxes' );

/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function wpdocs_my_display_callback( $post ) {
	echo "sdfa";
    // Display code/markup goes here. Don't forget to include nonces!
}

/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function wpdocs_save_meta_box( $post_id ) {
    // Save logic goes here. Don't forget to include nonce checks!
}
add_action( 'save_post', 'wpdocs_save_meta_box' );
