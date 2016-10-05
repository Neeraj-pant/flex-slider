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

} 
