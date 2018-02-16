<?php
/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'MPUsidebar_meta_boxes_setup' );
add_action( 'load-post-new.php', 'MPUsidebar_meta_boxes_setup' );

/* Meta box setup function. */
function MPUsidebar_meta_boxes_setup() {
  add_action( 'add_meta_boxes', 'MPUsidebar_add_meta_boxes' );
  add_action( 'save_post', 'MPUsidebar_save_content', 10, 2 );
  add_action( 'save_post', 'MPU_save_enablesidebar', 10, 2 );
}


function MPUsidebar_add_meta_boxes() {
  add_meta_box(
    'MPUsidebar-content',      // Unique ID
    esc_html__( 'Sidebar Content', 'example' ),    // Title
    'MPUsidebar_meta_box',   // Callback function
    'post',         // Admin page (or post type)
    'side',         // Context
    'default'         // Priority
  );
 
  add_meta_box(
    'MPUsidebar-content',      // Unique ID
    esc_html__( 'Sidebar Content', 'example' ),    // Title
    'MPUsidebar_meta_box',   // Callback function
    'page',         // Admin page (or post type)
    'side',         // Context
    'default'         // Priority
  );
  
}
/* Display the post meta box. */
function MPUsidebar_meta_box( $object, $box ) { ?>
<?php wp_nonce_field( basename( __FILE__ ), 'MPUsidebar_nonce' ); ?>
  	<div class="mpu_sidebar_menuholder">
		<p>This section controls the content for individual page sidebars.</p>
		<label>Disable the sidebar (Full width page):
			<input name="mpu_enablesidebar" type="checkbox" id="mpu_enablesidebar" value="true" <?php if(get_post_meta( get_the_ID(), 'mpu_enablesidebar', true) == 'true'){echo 'checked';} ?> />
		</label>
		<div class="sidebarContentHolder">
			<div class="sidebarContentForm">
				<p><strong>Sidebar Content</strong></p>
				<?php
				$editor_id = 'MPUsidebar_content';
				$content = get_post_meta( get_the_ID(), 'MPUsidebar_content', true);
				wp_editor( $content, $editor_id );
				?>
				<p>Add the <code>[subnav]</code> shortcode to add an automatic subnav to the sidebar.</p>
				<p>Add a <code>[jumpmenu title="My Jumpmenu Title"]</code> shortcode to add a jump menu. This will generate based on the <code>h3</code> tags contained in a <code>[colwrapper]</code> section. <br/>You must set the <code>jumplist="true"</code> property of the section.</p>
				<p>Global items common to all pages can be added to the <strong>Common Sidebar</strong> in the <a href="/wp-admin/widgets.php">widgets</a> section of the admin.</p>
			</div>
  		</div>
   	</div>
<?php 
}

/* Save the meta box's post metadata. */
function MPUsidebar_save_content( $post_id, $post ) {
	global $post;
	if ( !isset( $_POST['MPUsidebar_nonce'] ) || !wp_verify_nonce( $_POST['MPUsidebar_nonce'], basename( __FILE__ ) ) )
		return $post_id;
  	$new_meta_value =$_POST['MPUsidebar_content'];
	$meta_key = 'MPUsidebar_content';
  	$meta_value = get_post_meta( $post_id, $meta_key, true );
  	if ( $new_meta_value && '' == $meta_value )
    	add_post_meta( $post_id, $meta_key, $new_meta_value, true );
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );
  	elseif ( '' == $new_meta_value && $meta_value )
    	delete_post_meta( $post_id, $meta_key, $meta_value );
}

function MPU_save_enablesidebar( $post_id  ) {
	global $post;
	if ( !isset( $_POST['MPUsidebar_nonce'] ) || !wp_verify_nonce( $_POST['MPUsidebar_nonce'], basename( __FILE__ ) ) )
		return $post_id;
  	$new_meta_value =$_POST['mpu_enablesidebar'];
	$meta_key = 'mpu_enablesidebar';
  	$meta_value = get_post_meta( $post_id, $meta_key, true );
  	if ( $new_meta_value && '' == $meta_value )
    	add_post_meta( $post_id, $meta_key, $new_meta_value, true );
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );
  	elseif ( '' == $new_meta_value && $meta_value )
    	delete_post_meta( $post_id, $meta_key, $meta_value );
}




?>