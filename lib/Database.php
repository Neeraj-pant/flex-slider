<?php

/*
* Class For All db queries.
* @version 1.0
* @author Neeraj Pant
*/

// namespace FlexSlider\lib;

class Database
{

    // Wordpress default database object
    private $wpdb;
    private $table_sliders;
    private $table_slider_slides;
    private $table_slide_meta;

    public function __construct()
    {
        global $wpdb;

        $this->wpdb = $wpdb;
        $this->table_sliders = $this->wpdb->prefix . 'fl_sliders';
        $this->table_slider_slides = $this->wpdb->prefix . 'fl_slider_slides';
        $this->table_slide_meta = $this->wpdb->prefix . 'fl_slider_meta';
    }



    /**
     * Gets All Active Sliders
     */
    public function getAllSliders()
    {
        $query = 'SELECT s.*, ss.total_slides FROM ' . $this->table_sliders . ' as s '
            . ' LEFT JOIN ( '
            . ' SELECT count(*) as total_slides, slider_id FROM ' . $this->table_slider_slides . ' GROUP BY slider_id '
            . ' ) as ss on ss.slider_id = s.slider_id '
            . ' WHERE s.slider_status = 1 ';
        $results = $this->wpdb->get_results($query);
        return $results;
    }



    /**
     * Save Slider
     *
     * @param array $slider Array of slider name and type
     * @return integer|boolean                Return slider id on success or false
     */
    public function saveSlider($slider)
    {
        $this->wpdb->insert($this->table_sliders, $slider);
        return $this->wpdb->insert_id;
    }




    /**
     * Save Slider
     *
     * @param array $slider Array of slider name and type
     * @param integer $slider_id Id of slider
     * @return integer|boolean                        Return affected rows on success or false
     */
    public function updateSlider($slider, $slider_id)
    {
        $res = $this->wpdb->update($this->table_sliders, $slider, array('slider_id' => $slider_id));
        return $res;
    }



    /**
     * Update Slider Slides
     *
     * @param    array              $post       Slides data $_POST global value
     * @param    integer            $slider_id  Slides id
     * @return   integer|boolean    $res        Return affected rows on success or false
     */
    public function updateSlides($post, $slider_id)
    {
        $this->wpdb->delete($this->table_slider_slides, array('slider_id' => $slider_id));
        $res = $this->saveSlides($post, $slider_id);
        return $res;
    }



    /**
     * Save Slider Slides
     *
     * @param array $slides Array of slides
     * @param integer $slider_id Slider Id for reference slides to slider
     * @return boolean
     */
    public function saveSlides($slides, $slider_id)
    {
        $error = false;
        foreach ($slides as $key => $slide) {
            if (substr($key, 0, 11) == 'slider_data')
            {
                if (empty($slide))
                {
                    $slide = 0;
                }
                $slide_data = array(
                    'slider_id' => $slider_id,
                    'slider_media_id' => $slide
                );
                $res = $this->wpdb->insert($this->table_slider_slides, $slide_data, array('%d', '%d'));
                if (!$res) 
                {
                    $error = true;
                }
            }
        }
        if ($error)
        {
            return false;
        }
        else
        {
            return true;
        }

    }




    /* Save Slider Slides
    *
    * @param  integer	        $slider_id	Slider ID
    * @return integer|boolean   $result     Return slider data on success or false on fail
    */
    public function getSliderData($slider_id)
    {
        $query = 'SELECT s.*, p.id as media_id, p.post_title, p.guid as media FROM ' . $this->table_sliders . ' as s '
            . ' LEFT JOIN ' . $this->table_slider_slides . ' as ss on s.slider_id = ss.slider_id '
            . ' LEFT JOIN ' . $this->wpdb->prefix . 'posts as p on ss.slider_media_id = p.id '
            . ' WHERE s.slider_id = ' . $slider_id
            . ' AND s.slider_status = 1 '
            . ' ';
        $results = $this->wpdb->get_results($query);
        return $results;
    }




    /**
     * Delete Slider
     *
     * @param integer           $id    Slider id
     * @return integer|boolean         Return affected rows on success or false
     */
    public function deleteSlider($id)
    {
        $res = $this->wpdb->update($this->table_sliders, array('slider_status' => '0'), array('slider_id' => $id));
        return $res;
    }


}
