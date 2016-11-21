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
        add_action('admin_init', array($this, 'fsInit'), 1);
        register_activation_hook( __FILE__, array($this,'fsInstallDB') );
		add_action('admin_enqueue_scripts', array($this, 'fsIncludeStyleSheet'));
		add_action('admin_init', array($this, 'fsIncludeLib'));
		add_action('admin_init', array($this, 'fsInitDBObj'));
		add_action('admin_menu', array($this, 'fsCreateMenuItems'));
		add_action('wp_logout', array($this, 'fsRemoveSesson'));
    }




    /*
     * Initialize Slider Configuration
     */
    public function fsInit()
    {
    	if(!session_id()){
	    	session_start();
	    }

        defined('FLEX_VERSION')             OR define('FLEX_VERSION', 1.0);
        defined('FLEX_DIR_NAME')            OR define('FLEX_DIR_NAME', basename(__DIR__) );
        defined('FLEX_DUMMY_SLIDE_IMAGE')   OR define('FLEX_DUMMY_SLIDE_IMAGE', plugins_url(FLEX_DIR_NAME.'/images/default.png'));
    }


    /*
    * Destroy session
    */
    public function fsRemoveSesson()
    {
    	session_destroy();
    }



   /**
   * Initialize or create DB tables
   */
	public function fsInstallDB()
	{
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




    /**
     * Create Database class Object
     */
	public function fsInitDBObj()
	{
		$this->database = new Database();
	}




	/**
	* Creating Admin Menu Items
	*/
	public function fsCreateMenuItems()
	{
		add_menu_page('Flex Slider', __('Flex Slider'), 'manage_options', 'slides_listing', array($this, 'fsSliderListing'), 'dashicons-layout', '66');
		add_submenu_page('slides_listing', __('Add new Slider'), 'Add New', 'manage_options', 'add_slides', array($this, 'fsAddSlider'));
	}




	/**
	* Listing Page Admin Menu Link Page
	*/
	public function fsSliderListing()
	{
		if(isset($_POST['update_slider']))
		{
			$this->fsUpdateSlider();
		}

		if(isset($_GET['action']))
		{
			if($_GET['action'] === 'edit')
			{
				$this->fsEditSlide($_GET['slider']);
			}
			elseif($_GET['action'] === 'delete')
			{
				$this->fsDeleteSlide($_GET['slider']);
				wp_safe_redirect(admin_url('admin.php?page=slides_listing'));
				exit;
			}
			else
			{
				$url = 'admin.php?page=slides_listing';
				if(isset($_GET['paged']))
				{
					$url = 'admin.php?page=slides_listing&paged='.$_GET['paged'];
				}
				wp_safe_redirect(admin_url($url));
				exit;
			}
		}
		else
		{
			$sliders = $this->database->getAllSliders();

			$testListTable = new Listing($sliders);
			$testListTable->prepare_items();

			require_once(plugin_dir_path( __FILE__ ).'templates/slider_listing.php');
		}
	}





	/*
	* Add Slides Admin Menu Page
	*/
	public function fsAddSlider()
	{
		if(isset($_POST['save_slider']))
		{
			$this->fsSaveSlider();
		}

		require_once(plugin_dir_path( __FILE__ ).'templates/add_slider.php');
	}





	/*
	* Save Slider and Slides
	*/
	private function fsSaveSlider()
	{
		$slider = array(
            'slider_name' => $_POST['slider_name'],
		    'slider_type' => $_POST['slider_type']
        );
		$slider_id = $this->database->saveSlider($slider);

		if(!$slider_id)
		{
			fsFlashMessage( 'Error occurred during Save, some Sliders might not be Saved!', 'error');
		}
		else
		{
			$slides = $_POST;

			$save_slides = $this->database->saveSlides($slides, $slider_id);

            if($save_slides)
            {
                add_action('admin-notices', array('FlexSlier', 'fsAdminNotices'));
                fsFlashMessage( 'Slider Saved Successfully!', 'success');
            }
		}

		$url = admin_url('admin.php?page=slides_listing');
		wp_safe_redirect($url);
        exit;
	}






	/*
	* Update Slider and Slides
	*/
	private function fsUpdateSlider()
	{
		$slider['slider_name'] = $_POST['slider_name'];
		$slider['slider_type'] = $_POST['slider_type'];
		$slider_id = $_POST['slider_id'];
		$slider_update = $this->database->updateSlider($slider, $slider_id);
		if($slider_update === false)
		{
			fsFlashMessage('Failed To Update Slider', 'error');
		}
		else
		{
			$slides_update = $this->database->updateSlides($_POST, $slider_id);
			if($slides_update)
			{
				fsFlashMessage( 'Slider Updated Successfully!', 'success');
			}
			else
			{
				fsFlashMessage( 'Failed to Update Slider!', 'error');
			}
		}
	}





    /**
     * Edit slider
     *
     * @param   integer   $id     Slider id
     * @return  boolean
     */
    private function fsEditSlide($id)
    {
        $slider_data = $this->database->getSliderData($id);
        require_once(plugin_dir_path( __FILE__ ).'templates/add_slider.php');
    }




    /**
     * Delete slider
     *
     * @param   array|integer   $slider     Slider id
     * @return  boolean
     */
    private function fsDeleteSlide($slider)
	{
		$error = false;
		if (is_array($slider))
		{
			foreach ($slider as $id)
			{
				$del = $this->database->deleteSlider($id);
				if (!$del)
				{
					$error = true;
				}
			}
		}
		else
		{
			$del = $this->database->deleteSlider($slider);
			if(!$del)
			{
				$error = true;
			}
		}
		if(!$error)
		{
			fsFlashMessage( 'Slider Deleted Successfully!', 'success');
		}
		else
		{
			fsFlashMessage( 'Failed to Delete Slider!', 'error');
		}
    }





	/*
	 * Include StyleSheets
	 */
	public function fsIncludeStyleSheet( $hook )
	{
        wp_register_style('flex-slider-style', plugins_url(FLEX_DIR_NAME.'/css/slider_base.css'), false, FLEX_VERSION);
        wp_enqueue_style('flex-slider-style');

    	wp_enqueue_script('flex_elements_js', plugins_url(FLEX_DIR_NAME.'/js/flex_elements.js'), array('jquery'), FLEX_VERSION);
	}

}



$flex = new FlexSlider();



function fsFlashMessage($message, $type)
{
	$_SESSION[$type] = $message;
}



function dd($data)
{
	echo "<pre>";
	print_r($data);
	echo "</pre>";
	die;
}



function d($data)
{
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}
