# Exercise #2 - Add Fields to Built in Endpoints

You can modify built-in endpoints.

	add_action( 'rest_api_init', array( $this, 'register_restaurant_meta_fields' ) );

The register_rest_field() function adds fields to a REST response.	
	 
	   
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
