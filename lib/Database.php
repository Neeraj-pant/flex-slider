<?php

/*
* Class For All db queries.
* @version 1.0
* @author Neeraj Pant
*/

namespace FledSlider;

class Database{

	// Wordpress default database object
	private $wpdb;
	private $table_sliders;
	private $table_slider_slides;
	private $table_slide_meta;

	public function __construct(){
		global $wpdb;

		$this->wpdb = clone $wpdb;
		$this->table_sliders = $this->wpdb->prefix.'fl_sliders';
		$this->table_slider_slides = $this->wpdb->prefix.'fl_slider_slides';
		$this->table_slide_meta = $this->wpdb->prefix.'fl_slider_meta';
	}


	/**
	* Gets All Active Sliders
	*/
	public function getAllSliders(){
		$results = $this->wpdb->get_results( 'SELECT * FROM '.$this->table_sliders.' WHERE slider_status = 1' );
		return $results;
	}

} 
