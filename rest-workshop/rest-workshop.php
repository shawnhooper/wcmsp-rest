<?php
/**
 * Plugin Name: REST API Workshop Functionality
 * Description: Sample code used in Shawn's REST API Workshop @ WordCamp Minneapolis 2017
 * Author: Shawn Hooper
 */

/**
 * Class REST_API_Workshop_Plugin
 */
class REST_API_Workshop_Plugin {

	/**
	 * Hook into WordPress
	 * Set all Actions & Filters Here
	 */
	public function wordpress_hooks() {

		// Register Custom Post Type & Taxonomies
		add_action( 'init', array( $this, 'register_restaurant_cpt' ) );
		add_action( 'init', array( $this, 'register_restaurant_type_taxonomy' ) );

	}

	/**
	 * Register the Custom Post Type for "Restaurants"
	 */
	public function register_restaurant_cpt() {

		$args = array(
			'public' => true,
			'label'  => 'Restaurants',
			'supports' => array( 'title', 'comments', 'editor' ),
		);

		register_post_type( 'restaurant', $args );

	}

	/**
	 * Register the Custom Taxonomy for Restaurant Type
	 */
	public function register_restaurant_type_taxonomy() {

		register_taxonomy( 'restaurant_type', 'restaurant', array( 'label' => 'Restaurant Type', 'hierarchical' => true ) );

	}

}

// Start Me Up!
$restWorkshopPlugin = new REST_API_Workshop_Plugin();

// Hook into WordPress
$restWorkshopPlugin->wordpress_hooks();


/***
 * Setup Test Data for the Workshop
 *
 * @return bool
 */
function rest_api_workshop_setup_data() {

	$restaurants = get_posts(array( 'post_type' => 'restaurant') );

	if ( 0 !== count( $restaurants ) ) {
		return false;
	}

	require_once('test-data.php');

	return true;
}
register_activation_hook( __FILE__, 'rest_api_workshop_setup_data' );
