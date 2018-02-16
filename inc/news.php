<?php
function news_custom_post_type() {
  $labels = array(
    'name'               => _x( 'News', 'post type general name' ),
    'singular_name'      => _x( 'News', 'post type singular name' ),
    'add_new'            => _x( 'Add new News Item', 'news' ),
    'add_new_item'       => __( 'Add new News Item' ),
    'edit_item'          => __( 'Edit News' ),
    'new_item'           => __( 'New News' ),
    'all_items'          => __( 'All News Items' ),
    'view_item'          => __( 'View News' ),
    'search_items'       => __( 'Search News' ),
    'not_found'          => __( 'No News found' ),
    'not_found_in_trash' => __( 'No News found in the Trash' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'News'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'Holds our News Items',
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
    'has_archive'   => true,
    'menu_icon'     => 'dashicons-list-view',
  );
  register_post_type( 'news', $args ); 
}
add_action( 'init', 'news_custom_post_type' );

function news_updated_messages( $messages ) {
  global $post, $post_ID;
  $messages['news item'] = array(
    0 => '', 
    1 => sprintf( __('News Item updated. <a href="%s">View news item.</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('News Item updated.'),
    5 => isset($_GET['revision']) ? sprintf( __('News Item restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('News Item published. <a href="%s">View news item</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('News Item saved.'),
    8 => sprintf( __('News Item submitted. <a target="_blank" href="%s">Preview news item</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('News Item scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview news item</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('News Item draft updated. <a target="_blank" href="%s">Preview news item</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  return $messages;
}
add_filter( 'post_updated_messages', 'news_updated_messages' );

function news_contextual_help( $contextual_help, $screen_id, $screen ) { 
  if ( 'news' == $screen->id ) {

    $contextual_help = '<h2>News</h2>
    <p</p>';

  } elseif ( 'edit-product' == $screen->id ) {

    $contextual_help = '<h2>Editing News</h2>
    ';

  }
  return $contextual_help;
}
add_action( 'contextual_help', 'news_contextual_help', 10, 3 );

function news_taxonomies() {
  $labels = array(
    'name'              => _x( 'News Categories', 'taxonomy general name' ),
    'singular_name'     => _x( 'News Category', 'taxonomy singular name' ),
    'search_items'      => __( 'Search News Categories' ),
    'all_items'         => __( 'All News Categories' ),
    'parent_item'       => __( 'Parent News Category' ),
    'parent_item_colon' => __( 'Parent News Category:' ),
    'edit_item'         => __( 'Edit News Category' ), 
    'update_item'       => __( 'Update News Category' ),
    'add_new_item'      => __( 'Add new News Item Category' ),
    'new_item_name'     => __( 'New News Item Category' ),
    'menu_name'         => __( 'News Categories' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
  );
  register_taxonomy( 'news_category', 'news', $args );
}
add_action( 'init', 'news_taxonomies', 0 );




?>