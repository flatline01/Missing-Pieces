<?php
//Register settings
function theme_options_add(){
    register_setting( 'theme_settings', 'theme_settings' );
}
//Initialize options page
function add_options() {
	add_menu_page( __( 'Theme Options' ), __( 'Theme Options' ), 'manage_options', 'settings', 'theme_options_page');
}
//Grant access to options page 
add_action( 'admin_init', 'theme_options_add' );
add_action( 'admin_menu', 'add_options' );

//start settings page
function theme_options_page() {
	if ( ! isset( $_REQUEST['updated'] ) )
	$_REQUEST['updated'] = false;
	 
	//get variables outside scope
	global $color_scheme;
	
	?>
	<div class="wrap hmg_utils">
     	<div class="tabpanel">
    	<nav>
        	<a href="#formholder" class="active">Options</a><a href="#menus">Menus</a><a href="#shortcodes">Shortcodes</a><!--a href="#widgets">Widgets</a-->
        </nav>
    	<div class="tabBody active" id="formholder">
		<form method="post" action="options.php">
			<h2>Theme Options</h2>
            <h3>General Options</h3>
			<?php settings_fields( 'theme_settings' ); ?>
			<?php $options = get_option( 'theme_settings' ); ?>
            <label>
            	<span>Site Title:</span>
	            <input id="theme_settings[title]" type="text" name="theme_settings[title]" value="<?php esc_attr_e ($options['title'] ); ?>" placeholder="My Company Name"/>
            </label>
 			<label>
            	<span>Telephone:</span>
	            <input id="theme_settings[tel]" type="text" name="theme_settings[tel]" value="<?php esc_attr_e ($options['tel'] ); ?>" placeholder="1234567890"/>
            </label>
            <label>
            	<span>Telephone 2 / Fax:</span>
            	<input id="theme_settings[fax]" type="text" name="theme_settings[fax]" value="<?php esc_attr_e ($options['fax'] ); ?>" placeholder="1234567890"/>
            </label>
			<label>
            	<span>Email:</span>
            	<input id="theme_settings[email]" type="text" name="theme_settings[email]" value="<?php esc_attr_e ($options['email'] ); ?>" placeholder="info@mysite.com"/>
            </label>
            <label>
            	<span>Main Mailing Address:</span>
            	<input id="theme_settings[mailing]" type="text" name="theme_settings[mailing]" value="<?php esc_attr_e ($options['mailing'] ); ?>" placeholder="123 Anystreet, Anytown, Anystate 90210"/>
            </label>
            <label>
            	<span>Foot Note / Copyright Notice:</span>
            	<input id="theme_settings[footnote]" type="text" name="theme_settings[footnote]" value="<?php esc_attr_e ($options['footnote'] ); ?>" placeholder=""/>
            </label>
            <label>
            	<span>Contact page:</span>
				<?php 
				$args = array(
					'depth'                 => 0,
					'child_of'              => 0,
					'selected'              => $options['contact'],
					'echo'                  => 1,
					'name'                  => 'theme_settings[contact]',
					'id'                    => 'theme_settings[contact]', // string
					'show_option_none'      => null, // string
					'show_option_no_change' => null, // string
					'option_none_value'     => null, // string
				);
				wp_dropdown_pages( $args ); ?> 
            </label>
            <hr />
            <h3>Social Media links</h3>
            <p>Add the link to your social media page(s), including the <em>http://</em> or <em>https://</em>. Empty items will not appear on the site.</p>
			<label>
            	<span>Facebook:</span>
            	<input id="theme_settings[fb]" type="text" name="theme_settings[fb]" value="<?php esc_attr_e ($options['fb'] ); ?>" placeholder="http://facebook.com" />
            </label>
            <label>
            	<span>Twitter</span>:
            	<input id="theme_settings[twitter]" type="text" name="theme_settings[twitter]" value="<?php esc_attr_e ($options['twitter'] ); ?>"  placeholder="http://twitter.com"/>
            </label>
            <label>
            	<span>Instagram:</span>
            	<input id="theme_settings[instagram]" type="text" name="theme_settings[instagram]" value="<?php esc_attr_e ($options['instagram'] ); ?>" placeholder="http://instagram.com"/>
            </label>
            
            <label>
            	<span>Youtube:</span>
            	<input id="theme_settings[yt]" type="text" name="theme_settings[yt]" value="<?php esc_attr_e ($options['yt'] ); ?>" placeholder="http://youtube.com"/>
            </label>
            <label>
            	<span>LinkedIn:</span>
            	<input id="theme_settings[li]" type="text" name="theme_settings[li]" value="<?php esc_attr_e ($options['li'] ); ?>" placeholder="http://linkedin.com"/>
            </label>
            <hr/>
            <h3>Tracking Code</h3>
            <label for="theme_settings[ga]">Google Analytics tracking code Account Number</label>
            <input id="theme_settings[ga]" type="text" name="theme_settings[ga]" value="<?php esc_attr_e ($options['ga'] ); ?>" placeholder="UA-XXXXX-X"/>
            
            
			
            
			<?php submit_button(); ?>
		</form>
        </div>
        <div class="tabBody" id="shortcodes">
        	<h2>Shortcodes</h2>
            <p>This plugin/theme uses a variety of shortcodes to offer enhanced layout and functionality in the editor. Most will accept and optional Css class, that will added to the item.</p>
            <h3>Popup images</h3>
            <p>Open the media library, and get the urls for the normal and large sized images. As long as there is a path in the 'fullsize' option, the shortcode will add all the necessary classes and functionality.</p>
            <pre>[img thumb=path/to/image.jpg" fullsize="path/to/large.jpg" alt="Alt Text for the image." ]</pre>
            <h3>Columns</h3>
            <p>These will create various columns. Any normal content can be entered in the columns.</p>
            <p>The column group needs to be wrapped with </p>
       	  	<pre>[columnwrapper class="optionalCssClasses"][/columnwrapper]</pre>
            <p>You can then add various columns under it, and the theme will automatically adjust the columns</p>
            <pre>[column]Some Content[/column][column]Column 2[/column][column]Column 3[/column]</pre>
            <p>will add three columns to the page.</p>
            <p>If you add the following</p>
       	  	<pre>[leftcol][/leftcol][rightcol][/rightcol]</pre>
       	  	<p>two columns will be added to the page. Content will be aligned to the center.</p>
            <h3>Contact Form</h3>
            <p>Using the following shortcode will add a contact form to the page</p>
            <pre>[contact]</pre>
          	<p>This uses the contact.php page included in the theme files.</p>
        </div>
        <!--div class="tabBody" id="widgets">
        	<h2>Widgets</h2>
            <p>This theme uses two widget areas on the home page. <a href="/wp-admin/widgets.php">Click here</a> to go to the widget area of wordpress.</p>
        </div-->
        <div class="tabBody" id="menus">
        	<h2>Menus</h2>
            <p>This theme uses a custom menu. <a href="/wp-admin/nav-menus.php">Click here</a> to go to the menu area of wordpress.</p>
            <p>The menu appears in the upper left of the site. Pages will need to be added to the menu manually.</p>
            <p>The main menu will be automatically created and managed by Wordpress.</p>
        </div>
        </div>
	</div><!-- END wrap -->
	<?php
}

//social settings output function
function hmg_social(){
	$options = get_option( 'theme_settings' );
	if($options['fb'] !=""){
		echo ('<a href="'.$options['fb'].'" class="icon fb"><span class="label">Facebook</span></a>');
	}
	if($options['twitter'] !=""){
		echo ('<a href="'.$options['twitter'].'" class="icon tw"><span class="label">Twitter</span></a>');
	}
	if($options['instagram'] !=""){
		echo ('<a href="'.$options['instagram'].'" class="icon instagram"><span class="label">instagram</span></a>');
	}
	if($options['yt'] !=""){
		echo ('<a href="'.$options['yt'].'" class="icon instagram"><span class="label">instagram</span></a>');
	}
	if($options['li'] !=""){
		echo ('<a href="'.$options['li'].'" class="icon li"><span class="label">LinkedIn</span></a>');
	}
	if($options['email'] !=""){
		echo ('<a href="mailto:'.$options['email'].'" class="icon email"><span class="label">'.$options['email'].'</span></a>');
	}
	
}




?>