<?php
/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'MPUcss_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'MPUcss_post_meta_boxes_setup' );

/* Meta box setup function. */
function MPUcss_post_meta_boxes_setup() {
  add_action( 'add_meta_boxes', 'MPUcss_add_post_meta_boxes' );
  add_action( 'save_post', 'MPUcss_save_post_class_meta', 10, 2 );
}


function MPUcss_add_post_meta_boxes() {
  add_meta_box(
    'MPUcss-post-class',      // Unique ID
    esc_html__( 'Post Class', 'example' ),    // Title
    'MPUcss_post_class_meta_box',   // Callback function
    'post',         // Admin page (or post type)
    'side',         // Context
    'default'         // Priority
  );
 
  add_meta_box(
    'MPUcss-post-class',      // Unique ID
    esc_html__( 'Post Class', 'example' ),    // Title
    'MPUcss_post_class_meta_box',   // Callback function
    'page',         // Admin page (or post type)
    'side',         // Context
    'default'         // Priority
  );
  
}
/* Display the post meta box. */
function MPUcss_post_class_meta_box( $object, $box ) { ?>
<?php wp_nonce_field( basename( __FILE__ ), 'MPUcss_post_class_nonce' ); ?>
    <p>
        <label for="MPUcss-post-class"><?php _e( "Add a custom CSS class, which will be applied to WordPress' post class.", 'example' ); ?></label>
        <br /><br />
        <input class="widefat" type="text" name="MPUcss-post-class" id="MPUcss-post-class" value="<?php echo esc_attr( get_post_meta( $object->ID, 'MPUcss_post_class', true ) ); ?>" size="30" />
    </p>
<?php 
}

/* Save the meta box's post metadata. */
function MPUcss_save_post_class_meta( $post_id, $post ) {

  /* Verify the nonce before proceeding. */
  if ( !isset( $_POST['MPUcss_post_class_nonce'] ) || !wp_verify_nonce( $_POST['MPUcss_post_class_nonce'], basename( __FILE__ ) ) )
    return $post_id;

  /* Get the post type object. */
  $post_type = get_post_type_object( $post->post_type );

  /* Check if the current user has permission to edit the post. */
  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;

  /* Get the posted data and sanitize it for use as an HTML class. */
  $new_meta_value = ( isset( $_POST['MPUcss-post-class'] ) ? sanitize_html_class( $_POST['MPUcss-post-class'] ) : '' );

  /* Get the meta key. */
  $meta_key = 'MPUcss_post_class';

  /* Get the meta value of the custom field key. */
  $meta_value = get_post_meta( $post_id, $meta_key, true );

  /* If a new meta value was added and there was no previous value, add it. */
  if ( $new_meta_value && '' == $meta_value )
    add_post_meta( $post_id, $meta_key, $new_meta_value, true );

  /* If the new meta value does not match the old value, update it. */
  elseif ( $new_meta_value && $new_meta_value != $meta_value )
    update_post_meta( $post_id, $meta_key, $new_meta_value );

  /* If there is no new meta value but an old value exists, delete it. */
  elseif ( '' == $new_meta_value && $meta_value )
    delete_post_meta( $post_id, $meta_key, $meta_value );
}

//add the filter to the body_class hook
add_filter( 'body_class', 'MPUcss_post_class' );
function MPUcss_post_class( $classes ) {
  $post_id = get_the_ID();
  if ( !empty( $post_id ) ) {
    /* Get the custom post class. */
    $post_class = get_post_meta( $post_id, 'MPUcss_post_class', true );
    /* If a post class was input, sanitize it and add it to the post class array. */
    if ( !empty( $post_class ) )
      $classes[] = sanitize_html_class( $post_class );
  }
  return $classes;
}


?>