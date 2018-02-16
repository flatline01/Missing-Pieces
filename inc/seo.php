<?php
$options = get_option( 'theme_settings' );

if($options["mpuseo"] == "true"){
	/* If the user has selected to use the SEO plugin,
	Fire our meta box setup function on the post editor screen. */
	add_action( 'load-post.php', 'MPU_seo_setup' );
	add_action( 'load-post-new.php', 'MPU_seo_setup' );
	add_action('wp_head', 'MPU_seo_injector');
}

/* Meta box setup function. */
function MPU_seo_setup() {
  add_action( 'add_meta_boxes', 'MPU_add_seo_setup' );
  add_action( 'save_post', 'MPU_save_seo_setup', 10, 2 );
}

function my_enqueue_media_lib_uploader() {

    //Core media script
    wp_enqueue_media();

    // Your custom js file
    wp_register_script( 'media-lib-uploader-js', plugins_url( 'media-lib-uploader.js' , __FILE__ ), array('jquery') );
    wp_enqueue_script( 'media-lib-uploader-js' );
}
add_action('admin_enqueue_scripts', 'my_enqueue_media_lib_uploader');


function MPU_add_seo_setup() {
  add_meta_box(
    'MPU_seo',      // Unique ID
    esc_html__( 'MPU Simple Seo', 'example' ),    // Title
    'MPU_seo_metabox',   // Callback function
    'post',         // Admin page (or post type)
    'normal',         // Context
    'default'         // Priority
  );
 
  add_meta_box(
    'MPU_seo',      // Unique ID
    esc_html__( 'MPU Simple Seo', 'example' ),    // Title
    'MPU_seo_metabox',   // Callback function
    'page',         // Admin page (or post type)
    'normal',         // Context
    'default'         // Priority
  );
  
}

/* Display the meta box. */
function MPU_seo_metabox( $object, $box ) { ?>
<?php 
wp_nonce_field( basename( __FILE__ ), 'MPU_seo_nonce' ); 
$seo_arr = get_post_meta( $object->ID, "seo", false );
?>
<div class="mpu_seo MP_utils ">
   <h4>Use this to add simple SEO to the page.</h4>
   <div class="tabpanel fullwidth">
		<nav>
			<a href="#seo" class="active">SEO</a>
			<a href="#opengraph">OpenGraph</a>
		</nav>
   		<div class="tabBody active" id="seo">
			<p>
				<label for="MPU_seo_title"><?php _e( "SEO Title", 'example' ); ?></label>
				<input class="widefat" type="text" name="MPU_seo[]" id="MPU_seo_title" value="<?php echo $seo_arr[0][0] ?>" size="30" />
			</p>
			<p>
				<label for="MPU_seo_desc"><?php _e( "SEO Meta Description", 'example' ); ?></label>
				<textarea class="widefat" name="MPU_seo[]" id="MPU_seo_desc"><?php echo $seo_arr[0][1] ?></textarea>
			</p>
			<p>
				<label for="MPU_seo_keywords"><?php _e( "SEO Meta Keywords", 'example' ); ?></label>
				<input class="widefat" type="text" name="MPU_seo[]" id="MPU_seo_keywords" value="<?php echo $seo_arr[0][2] ?>" size="30" />
			</p>
    	</div>
		<div class="tabBody" id="opengraph">
		<h4>Optional Social media opengraph tags. If not set, the page will default to the regular SEO settings above.</h4>
		<p>
			<label for="MPU_og_title"><?php _e( "OpenGraph Title", 'example' ); ?></label>
			<input class="widefat" type="text" name="MPU_seo[]" id="MPU_og_title" value="<?php echo $seo_arr[0][3] ?>" size="30" />
		</p>
		<p>
			<label for="MPU_og_desc"><?php _e( "OpenGraph Description", 'example' ); ?></label>
			<textarea class="widefat" name="MPU_seo[]" id="MPU_og_desc"><?php echo $seo_arr[0][4] ?></textarea>
		</p>
		<p>Choose an OpenGraph image for this page. This prevents Social media services from using a random image from your page.</p>
		<input type="text" name="MPU_seo[]" id="MPU_og_img" value="<?php echo $seo_arr[0][5] ?>" />
		<input id="MPU_seo_OG_upload-button" type="button" class="button mediapicker" rel="MPU_og_img" value="Upload Image" />
		</div>
    </div>
</div>
<?php 
}

/* Save the meta box  */
function MPU_save_seo_setup( $post_id, $post ) {
/* Verify the nonce before proceeding. */
  	if ( !isset( $_POST['MPU_seo_nonce'] ) || !wp_verify_nonce( $_POST['MPU_seo_nonce'], basename( __FILE__ ) ) )
    	return $post_id;
	update_post_meta( $post_id, 'seo', $_POST["MPU_seo"] );
}

/*Add seo info to the head*/
function MPU_seo_injector(){
	global $post;
	$options = get_option( 'theme_settings' );
	$seo_arr = get_post_meta($post->ID, 'seo', true);
	
	$title = '';
	$desc='';
	$keywords='';
	$og_title='';
	$og_desc='';
	$og_url='';
	
	if($seo_arr[0]!=""){ $title = $seo_arr[0];}
	else{ $title = $options['seo_dt'];}
	
	if($seo_arr[1] !=""){$desc = $seo_arr[1];}
	else{$desc = $options['seo_d'];}
	
	if($seo_arr[3] !=""){ $og_title = $seo_arr[3];}
	else{$og_title = $options['seo_dt'];}
	
	if($seo_arr[4] !=""){$og_desc = $seo_arr[4];}
	else{$og_desc = $options['seo_d'];}
	
	?>
    <!--SEO-->
	<title><?php echo $title ?></title>
    <meta name="description" content="<?php echo $desc ?>"/>
    <meta http-equiv="Cache-control" content="no-cache"/>
    <meta name="keywords" content="<?php echo $seo_arr[2] ?>"/>
    <meta name="author" content="<?php echo $options['seo_sa'] ?>"/>
    <meta property="og:title" content="<?php echo $og_title ?>" /> 
    <meta name="og:site_name" content="<?php echo $options['seo_sn'] ?>"/>    
    <meta property="og:image" content="" /> 
    <meta property="og:description" content="<?php echo $og_desc  ?>" /> 
    <meta property="og:url" content="<?php echo get_permalink(); ?>"/>
    <!--/SEO-->
<?php		
}



?>