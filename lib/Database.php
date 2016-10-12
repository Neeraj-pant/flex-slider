<?php

/*
* Class For All db queries.
* @version 1.0
* @author Neeraj Pant
*/

// namespace FlexSlider\lib;

class Database{

	// Wordpress default database object
	private $wpdb;
	private $table_sliders;
	private $table_slider_slides;
	private $table_slide_meta;

	public function __construct(){
		global $wpdb;

		$this->wpdb = $wpdb;
		$this->table_sliders = $this->wpdb->prefix.'fl_sliders';
		$this->table_slider_slides = $this->wpdb->prefix.'fl_slider_slides';
		$this->table_slide_meta = $this->wpdb->prefix.'fl_slider_meta';
	}


	/**
	* Gets All Active Sliders
	*/
	public function getAllSliders(){
		$query = 'SELECT s.*, ss.total_slides FROM '.$this->table_sliders.' as s '
				.' LEFT JOIN ( '
					.' SELECT count(*) as total_slides, slider_id FROM '.$this->table_slider_slides.' GROUP BY slider_id '
					.' ) as ss on ss.slider_id = s.slider_id '
				.' WHERE s.slider_status = 1 ';
		$results = $this->wpdb->get_results( $query );
		return $results;
	}


	/**
	* Save Slider
	*
	* @param array 				$slider		Array of slider name and type
	* @return integer|boolean 				Return slider id on success or false
	*/
	public function saveSlider($slider)
	{
		$this->wpdb->insert( $this->table_sliders, $slider );
		return $this->wpdb->insert_id;
	}




	/**
	 * Save Slider Slides
	 *
	 * @param array		$slides		Array of slides
	 * @param integer	$slider_id	Slider Id for reference slides to slider
	 * @return boolean				return true or false
	 */
	public function saveSlides($slides, $slider_id)
    {
        $error = false;
        foreach($slides as $slide)
        {
            if(empty($slide))
            {
                $slide = 0;
            }
            $slide_data = array (
                'slider_id'     => $slider_id,
                'slider_media_id'  => $slide
            );
            $res = $this->wpdb->insert( $this->table_slider_slides, $slide_data, array('%d', '%d') );
            if(!$res)
            {
                $error = true;
            }
        }
        if($error)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

} 
