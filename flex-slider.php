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


class FlexSlider
{
	function __construct()
	{
        register_activation_hook( __FILE__, array($this,'FLInstallDB') );
		add_action('admin_menu', array($this, 'FSIncludeLib'));
		add_action('admin_menu', array($this, 'np_create_menu_items'));
	}


   /**
   * Initialize or create DB tables
   */
  public function FLInstallDB(){
	require_once(plugin_dir_path( __FILE__ ).'lib/classes/InstallDB.php');
	$db_install = new InstallDB();
  }
	
	/**
	* Include Library
	*/
	public function FSIncludeLib()
	{
        include_once(plugin_dir_path( __FILE__ ).'lib/Listing.php');
	}

	/**
	* Creating Admin Menu Items
	*/
	public function np_create_menu_items()
	{
		add_menu_page('Flex Slider', 'Slides', 'manage_options', 'slides_listing', array($this, 'np_slides_listing'), '', '66');
		add_submenu_page('slides_listing', 'Add new Slides', 'Add New', 'manage_options', 'add_slides', array($this, 'np_add_slides'));
	}


	/**
	* Listing Page Admin Menu Link Page
	*/
	public function np_slides_listing()
	{
		$data = array(
            array(
                'ID'        => 1,
                'title'     => '300',
                'rating'    => 'R',
                'director'  => 'Zach Snyder'
            ),
            array(
                'ID'        => 2,
                'title'     => 'Eyes Wide Shut',
                'rating'    => 'R',
                'director'  => 'Stanley Kubrick'
            ),
            array(
                'ID'        => 3,
                'title'     => 'Moulin Rouge!',
                'rating'    => 'PG-13',
                'director'  => 'Baz Luhrman'
            ),
            array(
                'ID'        => 4,
                'title'     => 'Snow White',
                'rating'    => 'G',
                'director'  => 'Walt Disney'
            ),
            array(
                'ID'        => 5,
                'title'     => 'Super 8',
                'rating'    => 'PG-13',
                'director'  => 'JJ Abrams'
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
	public function np_add_slides()
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