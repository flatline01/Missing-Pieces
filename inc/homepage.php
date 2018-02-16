<?php
add_action('add_meta_boxes', 'add_homepage_banner');
add_action( 'save_post', 'MPU_save_homepage_banner');
add_action( 'save_post', 'MPU_save_homepage_bannerimage');
add_action( 'save_post', 'MPU_save_homepage_phoneimage');
add_action( 'save_post', 'MPU_save_banner_bgcolor');
add_action( 'save_post', 'MPU_save_subpagebanneroption');

function add_homepage_banner()
{
    global $post;

    if(!empty($post))
    {
        $pageTemplate = get_post_meta($post->ID, '_wp_page_template', true);

        if($pageTemplate == 'page-templates/template-home.php' || $pageTemplate == 'page-templates/template-subpage.php')
        {
            add_meta_box(
                'MPU_homepagebanner', // $id
                'Page Banner', // $title
                'MPU_homepage_banner', // $callback
                'page', // $page
                'normal', // $context
                'high'); // $priority
        }
    }
}

function MPU_homepage_banner( )
{
	/*
	As with any project, this has grown beyond use in just the home page. This is also used on the subpage for the banner area.
	*/
	wp_nonce_field( basename( __FILE__ ), 'homepage_banner_nonce' );
	global $post;
	$pageTemplate = get_post_meta($post->ID, '_wp_page_template', true);
    ?>
    <div class="mpu_meta_holder banner">
    <?php 
	if($pageTemplate == 'page-templates/template-subpage.php')
		{
	?><h4>Use banner?</h4>
   	<label>Check this to enable the banner on the subpage:
	<input name="mpu_subpage_banner" type="checkbox" id="mpu_subpage_banner" value="true" <?php if(get_post_meta( get_the_ID(), 'mpu_subpage_banner', true) == 'true'){echo 'checked';} ?> />
   	</label>
    <hr />
    <?php  
		}
	?>
    <p>Add the left side banner image:</p>
    <label>
        <input type="text" name="MPU_homepage_bannerimage" id="MPU_homepage_bannerimage" value="<?php echo get_post_meta( get_the_ID(), 'MPU_homepage_bannerimage', true); ?>" placeholder="540 x 680 recommended" />
        <input id="MPU_upload-button" type="button" class="button mediapicker" value="Upload/Choose Image"/>
    </label>
    <hr/>
    <p>Center phone image:</p>
    <label>
        <input type="text" name="MPU_homepage_phoneimage" id="MPU_homepage_phoneimage" value="<?php echo get_post_meta( get_the_ID(), 'MPU_homepage_phoneimage', true); ?>" placeholder="340 x 580 recommended" />
        <input id="MPU_upload-button" type="button" class="button mediapicker" value="Upload/Choose Image"/>
    </label>
    <?php 
	if($pageTemplate == 'page-templates/template-subpage.php')
		{
	?>
   	<p>Optional Background Color (subpages only):</p>
	<input class="color-field" type="text" name="MPU_header_color" id="MPU_header_color" value="<?php echo get_post_meta( get_the_ID(), 'MPU_header_color', true); ?>"/>
    <?php  
		}
	?>
    <hr/>
    <p>Add content here for the banner right area:</p>
    <?php
	$editor_id = 'MPU_Homepagebanner';
	$content = get_post_meta( get_the_ID(), 'MPU_Homepagebanner', true);
	wp_editor( $content, $editor_id );
	/*
    <blockquote>
    <?php
	$myvals = get_post_meta(get_the_ID());
	foreach($myvals as $key=>$val){
		echo $key . ' : ' . $val[0] . '<br/>';
	}
	?>
    </blockquote>*/
	?>
    </div>
    <?php
}
function MPU_save_homepage_phoneimage( $post_id  ) {
	global $post;
	if ( !isset( $_POST['homepage_banner_nonce'] ) || !wp_verify_nonce( $_POST['homepage_banner_nonce'], basename( __FILE__ ) ) )
		return $post_id;
  	$new_meta_value =$_POST['MPU_homepage_phoneimage'];
	$meta_key = 'MPU_homepage_phoneimage';
  	$meta_value = get_post_meta( $post_id, $meta_key, true );
  	if ( $new_meta_value && '' == $meta_value )
    	add_post_meta( $post_id, $meta_key, $new_meta_value, true );
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );
  	elseif ( '' == $new_meta_value && $meta_value )
    	delete_post_meta( $post_id, $meta_key, $meta_value );
}

function MPU_save_banner_bgcolor( $post_id  ) {
	global $post;
	if ( !isset( $_POST['homepage_banner_nonce'] ) || !wp_verify_nonce( $_POST['homepage_banner_nonce'], basename( __FILE__ ) ) )
		return $post_id;
  	$new_meta_value =$_POST['MPU_header_color'];
	$meta_key = 'MPU_header_color';
  	$meta_value = get_post_meta( $post_id, $meta_key, true );
  	if ( $new_meta_value && '' == $meta_value )
    	add_post_meta( $post_id, $meta_key, $new_meta_value, true );
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );
  	elseif ( '' == $new_meta_value && $meta_value )
    	delete_post_meta( $post_id, $meta_key, $meta_value );
}
function MPU_save_subpagebanneroption( $post_id  ) {
	global $post;
	if ( !isset( $_POST['homepage_banner_nonce'] ) || !wp_verify_nonce( $_POST['homepage_banner_nonce'], basename( __FILE__ ) ) )
		return $post_id;
  	$new_meta_value =$_POST['mpu_subpage_banner'];
	$meta_key = 'mpu_subpage_banner';
  	$meta_value = get_post_meta( $post_id, $meta_key, true );
  	if ( $new_meta_value && '' == $meta_value )
    	add_post_meta( $post_id, $meta_key, $new_meta_value, true );
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );
  	elseif ( '' == $new_meta_value && $meta_value )
    	delete_post_meta( $post_id, $meta_key, $meta_value );
}




function MPU_save_homepage_bannerimage($post_id  ) {
	global $post;
	if ( !isset( $_POST['homepage_banner_nonce'] ) || !wp_verify_nonce( $_POST['homepage_banner_nonce'], basename( __FILE__ ) ) )
		return $post_id;
	
  	$new_meta_value =$_POST['MPU_homepage_bannerimage'];
	
  	$meta_key = 'MPU_homepage_bannerimage';
	
  	$meta_value = get_post_meta( $post_id, $meta_key, true );

  	if ( $new_meta_value && '' == $meta_value )
    	add_post_meta( $post_id, $meta_key, $new_meta_value, true );
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );

  	elseif ( '' == $new_meta_value && $meta_value )
    	delete_post_meta( $post_id, $meta_key, $meta_value );

}

function MPU_save_homepage_banner($post_id) {
	global $post;
	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST['homepage_banner_nonce'] ) || !wp_verify_nonce( $_POST['homepage_banner_nonce'], basename( __FILE__ ) ) )
		return $post_id;
	
	/* Get the posted data and sanitize it for use as an HTML class. */
  	$new_meta_value =$_POST['MPU_Homepagebanner'];
	
	/* Get the meta key. */
  	$meta_key = 'MPU_Homepagebanner';
	
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