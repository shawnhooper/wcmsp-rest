# Exercise #2 - Add a Custom Route

You can add your own route 

	register_rest_route( $this->namespace, '/restaurant/', array(
		'methods' => WP_REST_Server::READABLE,
		'callback' => array( $this, 'get_restaurant' ),
		'permissions_callback' => null,
		'args' => array()
	));

	register_rest_route( $this->namespace, '/restaurant/(?P<id>\d+)', array(
		'methods' => WP_REST_Server::READABLE,
		'callback' => array( $this, 'get_restaurant' ),
		'permissions_callback' => null,
	));
