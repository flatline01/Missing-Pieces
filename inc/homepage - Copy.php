<?php

add_action('add_meta_boxes', 'add_homepage_banner');
add_action( 'save_post', 'MPU_save_homepage_banner', 10, 2 );
function add_homepage_banner()
{
    global $post;

    if(!empty($post))
    {
        $pageTemplate = get_post_meta($post->ID, '_wp_page_template', true);

        if($pageTemplate == 'page-templates/template-home.php' )
        {
            add_meta_box(
                'MPU_homepagebanner', // $id
                'Homepage Banner', // $title
                'MPU_homepage_banner', // $callback
                'page', // $page
                'normal', // $context
                'high'); // $priority
        }
    }
}

function MPU_homepage_banner()
{
	wp_nonce_field( basename( __FILE__ ), 'homepage_banner_nonce' );
	
    ?>
    <p>Add content here for the homepage banner area:</p>
    <?php
	$content = get_post_meta($post->ID, 'MPUhomepagebanner', true);
	$text = get_post_meta($post->ID, 'MPUhomepagebanner', true);
	wp_editor( $text, 'MPUhomepagebanner', $settings = array() );
	
	
}


function MPU_save_homepage_banner( $post_id, $post ) {

  /* Verify the nonce before proceeding. */
  if ( !isset( $_POST['homepage_banner_nonce'] ) || !wp_verify_nonce( $_POST['homepage_banner_nonce'], basename( __FILE__ ) ) )
    return $post_id;

  /* Get the post type object. */
  $post_type = get_post_type_object( $post->post_type );

  /* Check if the current user has permission to edit the post. */
  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;

  /* Get the meta key. */
  $meta_key = 'MPUhomepagebanner';

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