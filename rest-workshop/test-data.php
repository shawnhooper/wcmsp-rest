<?php

register_taxonomy( 'restaurant_type', 'restaurant', array( 'hierarchical' => true ) );
$post_author = 1;
$thai = wp_insert_term( 'Thai', 'restaurant_type' );
$bar_grill = wp_insert_term( 'Bar Grill', 'restaurant_type' );
$seafood = wp_insert_term( 'Seafood', 'restaurant_type' );
$seafood = wp_insert_term( 'Steakhouse', 'restaurant_type' );

// MY THAI
$post_id = wp_insert_post( array(
	'post_type' => 'restaurant',
	'post_title'    => 'My Thai',
	'post_content'  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
	'post_status'   => 'publish',
	'post_author'   => $post_author,
	'tax_input' => array( 'restaurant_type' => array( get_term_by('slug', 'thai', 'restaurant_type')->term_id ) ),
	'meta_input' => array( 'address' => '2 S 5nd St, Minneapolis, MN 55401', 'hours' => '11:00 - 22:30', 'live_music' => false ),
) );

wp_insert_comment( array(
	'comment_post_ID' => $post_id,
	'comment_content' => 'Loved it! Would go again!',
	'comment_author_email' => 'sara@example.com',
	'comment_author' => 'Sara Smith',
	'comment_meta' => array('atmosphere' => 5, 'price' => 4, 'service' => 5),
) );

wp_insert_comment( array(
	'comment_post_ID' => $post_id,
	'comment_content' => 'Great atmosphere, too expensive',
	'comment_author_email' => 'joe@example.com',
	'comment_author' => 'Joe Jameson',
	'comment_meta' => array('atmosphere' => 5, 'price' => 2, 'service' => 5),
) );

wp_insert_comment( array(
	'comment_post_ID' => $post_id,
	'comment_content' => 'Hit the spot.',
	'comment_author_email' => 'shawn@example.com',
	'comment_author' => 'Shawn Hooper',
	'comment_meta' => array('atmosphere' => 3, 'price' => 4, 'service' => 3),
) );



// JOE'S BAR AND GRILL
$post_id = wp_insert_post( array(
	'post_type' => 'restaurant',
	'post_title'    => 'Joe\'s Bar and Grill',
	'post_content'  => 'Ut nec odio porttitor, pretium sem non, euismod nisl.',
	'post_status'   => 'publish',
	'post_author'   => $post_author,
	'tax_input' => array( 'restaurant_type' => array( get_term_by('slug', 'bar-grill', 'restaurant_type')->term_id ) ),
	'meta_input' => array( 'address' => '500 2nd Ave S, Minneapolis, MN 55402', 'hours' => '13:00 - 22:00', 'live_music' => true ),
) );


wp_insert_comment( array(
	'comment_post_ID' => $post_id,
	'comment_content' => 'Average',
	'comment_author_email' => 'sara@example.com',
	'comment_author' => 'Sara Smith',
	'comment_meta' => array('atmosphere' => 3, 'price' => 3, 'service' => 3),
) );

wp_insert_comment( array(
	'comment_post_ID' => $post_id,
	'comment_content' => 'Fun night spot!',
	'comment_author_email' => 'joe@example.com',
	'comment_author' => 'Joe Jameson',
	'comment_meta' => array('atmosphere' => 3, 'price' => 5, 'service' => 5),
) );

// SQUID LOUNGE
$post_id = wp_insert_post( array(
	'post_type' => 'restaurant',
	'post_title'    => 'Squid Lounge',
	'post_content'  => 'Quisque non facilisis dui, nec faucibus dui. Curabitur bibendum metus odio, nec ullamcorper quam ullamcorper et. ',
	'post_status'   => 'publish',
	'post_author'   => $post_author,
	'tax_input' => array( 'restaurant_type' => array( get_term_by('slug', 'seafood', 'restaurant_type')->term_id ) ),
	'meta_input' => array( 'address' => '10 South 6th St, Minneapolis, MN 55402', 'hours' => '16:00 - 23:00', 'live_music' => true ),
) );



// MOO
$post_id = wp_insert_post( array(
	'post_type' => 'restaurant',
	'post_title'    => 'Moo',
	'post_content'  => 'Ut magna nulla, ullamcorper ac diam sit amet, semper efficitur metus. ',
	'post_status'   => 'publish',
	'post_author'   => $post_author,
	'tax_input' => array( 'restaurant_type' => array( get_term_by('slug', 'steakhouse', 'restaurant_type')->term_id ) ),
	'meta_input' => array( 'address' => '920 2nd Avenue South, Minneapolis, MN 55402', 'hours' => '17:00 - 22:30', 'live_music' => false ),
) );


wp_insert_comment( array(
	'comment_post_ID' => $post_id,
	'comment_content' => 'Tasty!',
	'comment_author_email' => 'sara@example.com',
	'comment_author' => 'Sara Smith',
	'comment_meta' => array('atmosphere' => 4, 'price' => 5, 'service' => 5),
) );

wp_insert_comment( array(
	'comment_post_ID' => $post_id,
	'comment_content' => 'Hated it!',
	'comment_author_email' => 'joe@example.com',
	'comment_author' => 'Joe Jameson',
	'comment_meta' => array('atmosphere' => 1, 'price' => 1, 'service' => 1),
) );

wp_insert_comment( array(
	'comment_post_ID' => $post_id,
	'comment_content' => 'It was ok.',
	'comment_author_email' => 'shawn@example.com',
	'comment_author' => 'Shawn Hooper',
	'comment_meta' => array('atmosphere' => 3, 'price' => 3, 'service' => 3),
) );


// SURF AND TURF
wp_insert_post( array(
	'post_type' => 'restaurant',
	'post_title'    => 'Surf and Turf',
	'post_content'  => 'Quisque non facilisis dui, nec faucibus dui. Curabitur bibendum metus odio, nec ullamcorper quam ullamcorper et. Cras nec eros suscipit, vehicula dolor et, eleifend mi.',
	'post_status'   => 'publish',
	'post_author'   => $post_author,
	'tax_input' => array( 'restaurant_type' => array( get_term_by('slug', 'steakhouse', 'restaurant_type')->term_id, get_term_by('slug', 'seafood', 'restaurant_type')->term_id ) ),
	'meta_input' => array( 'address' => '920 2nd Avenue South, Suite 100, International Center II, Minneapolis, MN 55402', 'hours' => '17:00 - 22:30', 'live_music' => false ),
) );