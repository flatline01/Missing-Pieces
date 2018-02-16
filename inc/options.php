<?php
//Register settings
function theme_options_add(){
    register_setting( 'theme_settings', 'theme_settings' );
}
//Initialize options page
function add_options() {
	add_menu_page( __( 'MP Utilities' ), __( 'MP Utilities' ), 'manage_options', 'MP-utilities', 'theme_options_page');
}
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  $mimes['json'] = 'application/json';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');
//Grant access to options page 
add_action( 'admin_init', 'theme_options_add' );
add_action( 'admin_menu', 'add_options' );

//add media library integration
function optionspage_uploader_init() {

    //Core media script
    wp_enqueue_media();

    // Your custom js file
    wp_register_script( 'media-lib-uploader-js', plugins_url( 'media-lib-uploader.js' , __FILE__ ), array('jquery') );
    wp_enqueue_script( 'media-lib-uploader-js' );
}
add_action('admin_enqueue_scripts', 'optionspage_uploader_init');

//start settings page
function theme_options_page() {
	if ( ! isset( $_REQUEST['updated'] ) )
	$_REQUEST['updated'] = false;
	 
	//get variables outside scope
	global $color_scheme;
	$options = get_option( 'theme_settings' );
	?>
	<div class="wrap MP_utils">
    	<h1>Missing Pieces &amp; Utilities</h1> 
        <p>MPU adds various missing items and functionality to Wordpress.</p>
        <p>This plugin uses native WP functions and styles as much as possible to keep the CMS light and responsive.</p>
        <form method="post" action="options.php"> 
		<?php settings_fields( 'theme_settings' ); ?>
     	<div class="tabpanel">
            <nav>
                <a href="#options" class="active" >Options</a>
                <a href="#shortcodes" >Shortcodes</a>
               	<?php
					if($options['mpuseo'] == 'true'){ echo '<a href="#seodefaults">SEO Defaults &amp; Settings</a>';}
				?>

            </nav>
            <div class="tabBody active" id="options">
                <h2>Options</h2>
                <div class="option">
                    <label>
                        <span>Use MP&amp;Utilities SEO plugin?</span>
                        <input name="theme_settings[mpuseo]" type="checkbox" id="mpuseo" value="true" <?php if($options['mpuseo'] == 'true'){echo 'checked';} ?> />
                    </label>
                    <p>If you use a another SEO plugin, disable this option. The MPU SEO plugin is super lightweight and no frills.</p>
                </div>
                <div class="option">
                	<label>
                        <span>Copyright Notice:</span>
                        <input id="theme_settings[footnote]" type="text" name="theme_settings[footnote]" value="<?php esc_attr_e ($options['footnote'] ); ?>" placeholder="MyCompany, LLC"/>
            		</label>
                    <p>(year is set automatically)</p>
                </div>
              <div class="option">
                	<h4>Favicons</h4>
               		<p>The favicon.ico file should be added to the root of the site. You can generate a set of favicons <a href="http://realfavicongenerator.net/" target="_blank">here</a>. Other versions can be set here.</p>
                    <label>Apple Touch Icon:
                        <input type="text" name="theme_settings[apple-touch-icon]" id="theme_settings[apple-touch-icon]" value="<?php esc_attr_e ($options['apple-touch-icon'] ); ?>" />
                        <input id="MPU_seo_ati_upload-button" type="button" class="button mediapicker" value="Upload/Choose Image" rel="theme_settings[apple-touch-icon]"/>
                    </label>
					<label>Favicon 32x32:
                        <input type="text" name="theme_settings[icon32]" id="theme_settings[icon32]" value="<?php esc_attr_e ($options['icon32'] ); ?>" />
                        <input id="MPU_seo_i32_upload-button" type="button" class="button mediapicker" value="Upload/Choose Image" rel="theme_settings[icon32]"/>
                    </label>
                    <label>Favicon 16x16:
                        <input type="text" name="theme_settings[icon16]" id="theme_settings[icon16]" value="<?php esc_attr_e ($options['icon16'] ); ?>" />
                        <input id="MPU_seo_i16_upload-button" type="button" class="button mediapicker" value="Upload/Choose Image" rel="theme_settings[icon16]" />
                    </label>
                    <label>Manifest JSON:
                        <input type="text" name="theme_settings[manifest]" id="theme_settings[manifest]" value="<?php esc_attr_e ($options['manifest'] ); ?>" />
                        <input id="MPU_seo_man_upload-button" type="button" class="button mediapicker" value="Upload/Choose JSON" rel="theme_settings[manifest]"/>
                    </label>
                    <label>Safari Pinned Tab:
                        <input type="text" name="theme_settings[safari-pinned-tab]" id="theme_settings[safari-pinned-tab]" value="<?php esc_attr_e ($options['safari-pinned-tab'] ); ?>" />
                        <input id="MPU_seo_spt_upload-button" type="button" class="button mediapicker" value="Upload/Choose Image" rel="theme_settings[safari-pinned-tab]"/>
                    </label>
                    <label>Safari Mask Color:
                		<input type="text" name="theme_settings[safari-pinned-tab-color]" id="theme_settings[safari-pinned-tab-color]" value="<?php esc_attr_e ($options['safari-pinned-tab-color'] ); ?>" />
                    </label>
                    <label>Theme Color:
                		<input type="text" name="theme_settings[theme-color]" id="theme_settings[theme-color]" value="<?php esc_attr_e ($options['theme-color'] ); ?>" />
                    </label>
                </div>
                                
                <div class="option">
                	<label for="theme_settings[gplay]">
                    <span>Google Play badge:</span></label>
                    <textarea id="theme_settings[gplay]" type="text" name="theme_settings[gplay]"><?php esc_attr_e ($options['gplay']); ?></textarea>
                	<p>Go to the <a href="https://play.google.com/intl/en_us/badges/#badge-generator" target="_blank">Play Badge generator</a>, and paste the code supplied in the box above.</p>
                  	<p>This can be added to content with the [playbadge] short code, or &lt;?php gplay_badge();?&gt; in theme code.</p>
                </div>
                <div class="option">
                	<label for="theme_settings[appstorelink]">
                        <span>Apple Store Link:</span></label>
                        <textarea id="theme_settings[appstorelink]" type="text" name="theme_settings[appstorelink]"><?php esc_attr_e ($options['appstorelink'] ); ?></textarea>
            		<p>Go to the <a href="https://linkmaker.itunes.apple.com/en-us" target="_blank">link maker</a>, find your app, and get the embed code. Past the code into the box above</p>
                    <p>This can be added to content with the [appstore] short code, or &lt;?php appstore_badge();?&gt; in theme code.</p>
                </div>
                <hr/>
                <h3>Google Webmaster options</h3>
                <div class="option">
                    <label for="theme_settings[ga]">Google Analytics tracking code Account Number</label>
                    <input id="theme_settings[ga]" type="text" name="theme_settings[ga]" value="<?php esc_attr_e ($options['ga'] ); ?>" placeholder="UA-XXXXX-X"/>
                    <label for="theme_settings[gwmvc]">Google Webmaster verification code</label>
                    <input id="theme_settings[gwmvc]" type="text" name="theme_settings[gwmvc]" value="<?php esc_attr_e ($options['gwmvc'] ); ?>" placeholder="0123456789"/>

            	</div>
                
            </div>
            <div class="tabBody" id="seodefaults">
                <h2>SEO Defaults &amp; Settings</h2>
                <p>Use these to set SEO defaults. Page level SEO settings will override and/or add to these settings</p>
                <div class="option">
                	<h4>Title</h4>
                	<label for="theme_settings[seo_ptp]">Page Title Prefix:</label>
                    <input id="theme_settings[seo_ptp]" type="text" name="theme_settings[seo_ptp]" value="<?php esc_attr_e ($options['seo_ptp'] ); ?>" placeholder="sitename | "/>
                    <label for="theme_settings[seo_tp]">Page Title Postfix:</label>
                    <input id="theme_settings[seo_tp]" type="text" name="theme_settings[seo_tp]" value="<?php esc_attr_e ($options['seo_tp'] ); ?>" placeholder=" - sitename"/>
                    <p>These add a pre/post string to the page title.</p>
                	<label for="theme_settings[seo_dt]">Default title</label>
                    <input id="theme_settings[seo_dt]" type="text" name="theme_settings[seo_dt]" value="<?php esc_attr_e ($options['seo_dt'] ); ?>" placeholder="Mysite.com Home of fine products "/>
                    <p>This will set a default page title and OpenGraph title.</p>
                </div>
                <div class="option">
                	<label for="theme_settings[seo_d]">Description:</label>
                    <textarea id="theme_settings[seo_d]" type="text" name="theme_settings[seo_d]"><?php esc_attr_e ($options['seo_d'] ); ?></textarea>
                    <p>This will set the default description and OpenGraph description.</p>
                </div>
                <div class="option">
                	<label for="theme_settings[seo_sn]">Site name</label>
                    <input id="theme_settings[seo_sn]" type="text" name="theme_settings[seo_sn]" value="<?php esc_attr_e ($options['seo_sn'] ); ?>" placeholder="My Site"/>
                </div>
                <div class="option">
                	<label for="theme_settings[seo_sa]">Author</label>
                    <input id="theme_settings[seo_sa]" type="text" name="theme_settings[seo_sa]" value="<?php esc_attr_e ($options['seo_sa'] ); ?>" placeholder="Site, LLC"/>
                </div>
                <div class="option">
                	<label for="theme_settings[seo_ogi]">OG Image</label>
                    <input type="text" name="theme_settings[seo_ogi]" id="theme_settings[seo_ogi]" value="<?php esc_attr_e ($options['seo_ogi'] ); ?>" />
    				<input id="MPU_seo_OG_upload-button" type="button" class="button mediapicker" rel="theme_settings[seo_ogi]" value="Upload Image" />
                    <p>This is a default image for OpenGraph shares.</p>
                </div>
            </div>
            <div class="tabBody" id="shortcodes">
                <h2>Shortcodes</h2>
                <p>This is a short list of available shortcodes</p>
            </div>
            <!--div class="tabBody" id="menus">
                <h2>Menus</h2>
                <p>The theme uses three main menus. They can be found on the <a href="/wp-admin/nav-menus.php">Menus</a> page.</p>
            </div-->
            <!--div class="tabBody" id="widgets">
                <h2>Widgets</h2>
                <p>This theme uses two widget areas on the home page. <a href="/wp-admin/widgets.php">Click here</a> to go to the widget area of wordpress.</p>
            </div-->
        
        </div>
        <?php submit_button(); ?>
        </form>
	</div><!-- END wrap -->
	<?php
}

//output GA code in the head
function ga(){
	$options = get_option( 'theme_settings' );
	if(!empty($options['ga'])){
		?>
        <!-- Google Analytics -->
		<script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
        
        ga('create', '<?php echo($options['ga']);?>', 'auto');
        ga('send', 'pageview');
        </script>
        <!-- End Google Analytics -->
        <?php
	}	
}
add_action('wp_head', 'ga');

//output google webmaster verification
function googlewebmasterverification(){
	$options = get_option( 'theme_settings' );
	if(!empty($options['gwmvc'])){
		?>
		<meta name="google-site-verification" content="<?php echo($options['gwmvc']);?>">   
		<?php
	}
}
add_action('wp_head', 'googlewebmasterverification');

function setfavicons(){
	$options = get_option( 'theme_settings' );
	?>
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $options['apple-touch-icon'] ?>">
    <link rel="icon" type="image/png" href="<?php echo $options['icon32'] ?>" sizes="32x32">
    <link rel="icon" type="image/png" href="<?php echo $options['icon16'] ?>" sizes="16x16">
    <link rel="manifest" href="<?php echo $options['manifest'] ?>">
    <link rel="mask-icon" href="<?php echo $options['safari-pinned-tab'] ?>" color="<?php echo $options['safari-pinned-tab-color'] ?>">
    <meta name="theme-color" content="<?php echo $options['theme-color'] ?>">
    <?php
}
add_action('wp_head', 'setfavicons');

//create play badges
function gplay_badge(){
	$options = get_option( 'theme_settings' );
    echo('<div class="gplaybadge">'.$options['gplay'].'</div>');
}
//[playbadge]
function playbadge( $atts, $content = null ) {
	$options = get_option( 'theme_settings' );
 	return '<div class="gplaybadge">'.$options['gplay'].'</div>';
}
add_shortcode( 'playbadge', 'playbadge' ); 

function appstore_badge(){
	$options = get_option( 'theme_settings' );
    echo('<div class="appstore">'.$options['appstorelink'].'</div>');
}
//[appstore]
function appstore( $atts, $content = null ) {
	$options = get_option( 'theme_settings' );
 	return '<div class="appstore">'.$options['appstorelink'].'</div>';
}
add_shortcode( 'appstore', 'appstore' ); 









?>