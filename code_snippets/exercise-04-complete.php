<?php
/**
 * Plugin Name: REST API Workshop Functionality (Complete)
 * Description: Sample code used in Shawn's REST API Workshop @ WordCamp Minneapolis 2017
 * Author: Shawn Hooper
 */

/**
 * Class REST_API_Workshop_Plugin
 */
class REST_API_Workshop_Plugin {

	protected $namespace = 'restaurant-api/v1';

	/**
	 * Hook into WordPress
	 * Set all Actions & Filters Here
	 */
	public function wordpress_hooks() {

		// Register Custom Post Type & Taxonomies
		add_action( 'init', array( $this, 'register_restaurant_cpt' ) );
		add_action( 'init', array( $this, 'register_restaurant_type_taxonomy' ) );
		add_action( 'rest_api_init', array( $this, 'register_restaurant_meta_fields' ) );
		add_action( 'rest_api_init', array( $this, 'register_restaurant_endpoint' ) );

	}

	/**
	 * Register the Custom Post Type for "Restaurants"
	 */
	public function register_restaurant_cpt() {

		$args = array(
			'public' => true,
			'label'  => 'Restaurants',
			'supports' => array( 'title', 'comments', 'editor' ),
			'show_in_rest' => true,
		);

		register_post_type( 'restaurant', $args );

	}

	/**
	 * Register the Custom Taxonomy for Restaurant Type
	 */
	public function register_restaurant_type_taxonomy() {

		register_taxonomy( 'restaurant_type', 'restaurant', array( 'label' => 'Restaurant Type', 'hierarchical' => true ) );

	}

	/**
	 * Add fields to the restaurant REST response
	 */
	public function register_restaurant_meta_fields() {
		register_rest_field( 'restaurant', 'address',
			array(
				'get_callback'    => array( $this, 'get_address_meta_field')
			)
		);

		register_rest_field( 'restaurant', 'hours',
			array(
				'get_callback'    => array( $this, 'get_hours_meta_field')
			)
		);

		register_rest_field( 'restaurant', 'live_music',
			array(
				'get_callback'    => array( $this, 'get_live_music_meta_field')
			)
		);

		register_rest_field( 'restaurant', 'restaurant_type',
			array(
				'get_callback'    => array( $this, 'get_restaurant_type_taxonomy')
			)
		);
	}

	public function get_address_meta_field( $object ) {
		return get_post_meta( $object['id'], 'address', true );
	}

	public function get_hours_meta_field( $object ) {
		return get_post_meta( $object['id'], 'hours', true );
	}

	public function get_live_music_meta_field( $object ) {
		return (bool) get_post_meta( $object['id'], 'live_music', true );
	}

	public function get_restaurant_type_taxonomy( $object ) {
		return wp_get_post_terms( $object['id'], 'restaurant_type' );
	}

	public function register_restaurant_endpoint() {

		register_rest_route( $this->namespace, '/restaurant/', array(
			'methods' => WP_REST_Server::READABLE,
			'callback' => array( $this, 'get_restaurant' ),
			'permissions_callback' => null,
			'args' => array()
		));

		register_rest_route( $this->namespace, '/restaurant/', array(
			'methods' => WP_REST_Server::CREATABLE,
			'callback' => array( $this, 'new_restaurant' ),
			'permission_callback' => function () {
				return true;
			},
			'args' => $this->get_restaurant_schema(),
		));

		register_rest_route( $this->namespace, '/restaurant/(?P<id>\d+)', array(
			'methods' => WP_REST_Server::READABLE,
			'callback' => array( $this, 'get_restaurant' ),
			'permissions_callback' => null,
		));
	}

	public function get_restaurant_schema() {

		return array(
			'name' => array(
				'required' => true,
				'type' => 'string',
				'description' => 'The name of the restaurant',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'address' => array(
				'required' => true,
				'type' => 'string',
				'description' => 'The restaurant\'s physical address',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'hours' => array(
				'required' => true,
				'type' => 'string',
				'description' => 'The restaurant\'s hours',
				'sanitize_callback' => 'sanitize_text_field',
			),
			'liveMusic' => array(
				'required' => true,
				'type' => 'boolean',
				'description' => 'Does this restaurant have live music?',
			),
			'restaurantTypes' => array(
				'required' => true,
				'type' => 'array',
				'description' => 'What types of food does this restaurant serve',
				'validate_callback' => function( $param, $request, $key ) {
					foreach( $param as $type ) {
						$term = get_term_by('slug', $type, 'restaurant_type' );
						if ( false === $term ) {
							return new WP_Error('invalid_retaurant_type', 'Invalid restaurant type provided', array('code' => 401 ) );
						}
					}

					return true;
				}
			),
		);

	}

	public function get_restaurant( WP_REST_Request $request ) {

		if ( null === $request->get_param('id') ) {
			$query = new WP_Query( array(
					'post_type' => 'restaurant',
					'posts_per_page' => -1,
				)
			);

			return array_map( array( $this, 'format_restaurant_response' ), $query->posts );

		}

		$post = get_post( $request->get_param('id' ) );

		if ( null === $post ) {
			return new WP_Error('not_found', 'A restaurant with this ID does not exist', array('status' => 404) );
		}

		return $this->format_restaurant_response( $post );

	}

	public function format_restaurant_response( $post ) {

		$response = array();

		$response['id'] = $post->ID;
		$response['name'] = $post->post_title;
		$response['description'] = $post->post_content;
		$response['address'] = get_post_meta( $post->ID, 'address', true );
		$response['hours'] = get_post_meta( $post->ID, 'hours', true );
		$response['hasLiveMusic'] = (bool) get_post_meta( $post->ID, 'live_music', true );
		$response['restaurantTypes'] = array_map( array( $this, 'get_term_name' ), wp_get_post_terms( $post->ID, 'restaurant_type' ) );
		$response['numberOfReviews'] = $this->get_review_count( $post->ID );

		return $response;

	}

	public function new_restaurant( WP_REST_Request $request ) {
		$args = array(
			'post_type' => 'restaurant',
			'post_title'    => $request->get_param('name'),
			'post_content'  => $request->get_param('description'),
			'post_status'   => 'publish',
			'post_author'   => get_current_user_id(),
			'meta_input' => array( 'address' => $request->get_param('address'), 'hours' => $request->get_param('hours'), 'live_music' => $request->get_param('liveMusic') ),
		);

		$post_id = wp_insert_post( $args );

		wp_set_object_terms( $post_id, $request->get_param('restaurantTypes'), 'restaurant_type' );

		return $this->format_restaurant_response( get_post( $post_id ) );
	}

	public function get_term_name( $term ) {
		return $term->name;
	}

	public function get_review_count( $post_id ) {
		return count( get_comments( array( 'post_id' => $post_id ) ) );
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
