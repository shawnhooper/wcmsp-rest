# Exercise #1 - Make a CPT Visible to the REST-API

In your **register_post_type()** call, you need to include the argument:

**show_in_rest' => true,**

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

Now, when you call http://rest.dev/wp-json/wp/v2/restaurant/ you'll see the posts.