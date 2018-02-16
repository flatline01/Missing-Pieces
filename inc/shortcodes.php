<?php
//shortcodes and fixes
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

//move wpautop filter to AFTER shortcode is processed
remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 99);
add_filter( 'the_content', 'shortcode_unautop',101 ); 
add_filter( 'the_content', 'remove_empty_p', 102);

//add additional editor options
function enable_more_buttons($buttons) {

$buttons[] = 'anchor';

return $buttons;
}
add_filter("mce_buttons_3", "enable_more_buttons");

//hook into the options page to make shortcodes
global $post;
$options = get_option( 'theme_settings' );

function remove_empty_p( $content ){
	// clean up p tags around block elements
	$content = preg_replace( array(
		'#<p>\s*<(div|aside|section|article|header|footer)#',
		'#</(div|aside|section|article|header|footer)>\s*</p>#',
		'#</(div|aside|section|article|header|footer)>\s*<br ?/?>#',
		'#<(div|aside|section|article|header|footer)(.*?)>\s*</p>#',
		'#<p>\s*</(div|aside|section|article|header|footer)#',
	), array(
		'<$1',
		'</$1>',
		'</$1>',
		'<$1$2>',
		'</$1',
	), $content );
	return preg_replace('#<p>(\s|&nbsp;)*+(<br\s*/*>)*(\s|&nbsp;)*</p>#i', '', $content);
}

//[checkbox] 
function checkbox( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'value' => '',
		'label' => '',
		'id'=>'',
		'class'=>'',
	), $atts );
	$nameid="";
	$val="";
	if($a['id']==""){
		$nameid =esc_attr($a['label']);
		$nameid = str_replace(' ', '_', $nameid);
	}
	else{
		$nameid =esc_attr($a['id']);
	}
	if($a['value']==""){
		$val =esc_attr($a['label']);
	}
	else{
		$val =esc_attr($a['value']);
	}
	
 	return '<label class="checkholder ' . esc_attr($a['class']) . '"><input type="checkbox" name="' . $nameid . '" id="' . $nameid . '" value="' . $val . '"/><span class="label">' . esc_attr($a['label']) . '</span></label>';
}
add_shortcode( 'checkbox', 'checkbox' );  

//[selectbox]
function selectbox( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'label' => '',
		'id'=>'',
		'class'=>'',
		'multiple'=>'',
		'sprite'=>'',
		
	), $atts );
	if($a['multiple'] == 'true'){
		$multiple = ' size="4" multiple ';	
	}
	return '<div class="selectholder' . esc_attr($a['class']) . '"><span class="label">' . esc_attr($a['label']) . '</span><select name="' . esc_attr($a['id']) . '" id="' . esc_attr($a['id']) . '" ' . $multiple . '>'  . do_shortcode($content) . '</select></div>';
}
add_shortcode( 'selectbox', 'selectbox' );  

//[option] 
function option( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'value' => '',
		'label' => '',
	), $atts );
	$val="";
	if($a['value'] !=""){
		$val=$a['value'];
	}
	else{
		$val = $a['label'];
	}
 	return '<option value="' . esc_attr($a['value']) . '">' . esc_attr($a['label']) . '</option>';
}
add_shortcode( 'option', 'option' ); 

//[clear]
function clear( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'class'=>'',
	), $atts );
 	return '<div class="clear"></div>';
}
add_shortcode( 'clear', 'clear' ); 


//[section]
function section( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'class'=>'',
		'id'=>'',
		'fullwidth'=>'false',
		'bgcolor'=>'#fff',
	), $atts );
	$output = '<section class="' . esc_attr($a['class']) . '" id="' . esc_attr($a['class']) . '" style="background-color:'.esc_attr($a['bgcolor']).';">';
	if($a['fullwidth'] =="false" ){ $output .='<div class="container clearafter">';}
	$output .= do_shortcode($content);
	if($a['fullwidth'] =="false"){ $output .='</div>';}
	$output .= '</section>';
 	return $output;
}
add_shortcode( 'section', 'section' );

//[item]
function item( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'class'=>'',
		'id'=>"",
	), $atts );
 	return '<div class="item ' . esc_attr($a['class']) . '">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'item', 'item' );

//[flexwrapper]
function flexwrapper( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'class'=>'',
		'id'=>"",
		'align'=>'',
		'justify'=>'',
	), $atts );
	
	
 	return '<div class="flexwrapper ' . esc_attr($a['class']) . ' '. esc_attr($a['align']) .' '. esc_attr($a['justify']) .'">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'flexwrapper', 'flexwrapper' );


//[buttongroup]
function buttongroup( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'link' => '',
		'text' => '',
		'class'=>'',
	), $atts );
 	return '<div class="buttonholder">'  . do_shortcode($content) . '</div>';
}
add_shortcode( 'buttongroup', 'buttongroup' );

//[button] 
function button( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'link' => '',
		'text' => '',
		'class'=>'',
	), $atts );
 	return '<a class="button ' . esc_attr($a['class']) . '" href="' . esc_attr($a['link']) . '">' . esc_attr($a['text']) . '</a>';
}
add_shortcode( 'button', 'button' );

//[col]
function col( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'class'=>'',
	), $atts );
 	return '<div class="col ' . esc_attr($a['class']) . '">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'col', 'col' ); 

//[colwrapper]
function colwrapper( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'class'=>'',
		'cols'=>'',
		'jumplist'=>'',
		'targets'=>'',
	), $atts );
	$cols = 'cols'. esc_attr($a['cols']);
	$jumplist = "";
	$targets = "";
	if(esc_attr($a['jumplist']) == "true"){
		$jumplist = 'data-jumplist="true"';

		if(esc_attr($a['targets']) == "true"){
			$targets = 'data-target="'.esc_attr($a['targets']).'"';
		}
		else{
			$targets = 'data-target="h3"';
		}
	}
 	return '<div class="colwrapper clearafter ' . esc_attr($a['class']) . '" '.$jumplist.' '.$targets.'>'  . do_shortcode($content)  . '</div>';
}
add_shortcode( 'colwrapper', 'colwrapper' ); 


//[accordion]
function accordion( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'class' => '',
		'id' => '',
	), $atts );
 	return '<div class="accordion ' . esc_attr($a['class']) . '" id="' . esc_attr($a['id']) . '">'  . do_shortcode($content) .  '</div>';
}
add_shortcode( 'accordion', 'accordion' ); 

//[accordionitem]
function accordionitem( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'class' => '',
	), $atts );
 	return '<div class="accordionitem ' . esc_attr($a['class']) . '">'  . do_shortcode($content) .  '</div>';
}
add_shortcode( 'accordionitem', 'accordionitem' ); 

//[accordiontitle]
function accordiontitle( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'class' => '',
	), $atts );
 	return '<h3 class="accordiontitle ' . esc_attr($a['class']) . '">'  . do_shortcode($content) .  '</h3>';
}
add_shortcode( 'accordiontitle', 'accordiontitle' ); 

//[accordioncontent]
function accordioncontent( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'class' => '',
	), $atts );
 	return '<div class="accordioncontent ' . esc_attr($a['class']) . '"><div class="contentholder">'  . $content .  '</div></div>';
}
add_shortcode( 'accordioncontent', 'accordioncontent' ); 

//[slider]
function slider( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'class' => '',
		'id' =>'',
	), $atts );
 	return '<div class="slider ' . esc_attr($a['class']) . '" id="' . esc_attr($a['id']) . '"><div class="slidercontainer"><div class="slides">'  . do_shortcode($content) .  '</div></div></div>';
}
add_shortcode( 'slider', 'slider' ); 
 
//[slide]
function slide( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'class' => '',
		'img' => '',
	), $atts );
 	return '<div class="slide ' . esc_attr($a['class']) . '"><div class="caption">'  . $content .  '</div></div>';
}
add_shortcode( 'slide', 'slide' ); 

//[marquee]
function marquee( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'class' => '',
	), $atts );
 	return '<div class="marquee ' . esc_attr($a['class']) . '">'  . do_shortcode($content) .  '</div>';
}
add_shortcode( 'marquee', 'marquee' ); 

//[subnav]
function subnav( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'class' => '',
	), $atts );
 	 
	global $post;
	if ($post->post_parent) {
		$ancestors=get_post_ancestors($post->ID);
		$root=count($ancestors)-1;
		$parent = $ancestors[$root];
	} else {
		$parent = $post->ID;
	}

	$children = wp_list_pages("title_li=&child_of=". $parent ."&echo=0&depth=1");

	if ($children) { 
		// If there is a parent, display the link.
		$parent_title = get_the_title( $post->post_parent );
	?>
	<div class="subpagenav">
		<?php if ( $parent_title != the_title( ' ', ' ', false ) ) {
			echo '<h3><a href="' . esc_url( get_permalink( $post->post_parent ) ) . '" alt="' . esc_attr( $parent_title ) . '">' . $parent_title . '</a></h3>';
		}?>
		<ul>
		<?php echo $children; ?>
		</ul>
	</div>
	<?php } 
	
}
add_shortcode( 'subnav', 'subnav' ); 

//[jumpmenu]
function jumpmenu( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'class' => '',
		'title' => '',
	), $atts );
 	return '<div class="jumpmenu ' . esc_attr($a['class']) . '"><h3>' . esc_attr($a['title']) . '</h3></div>';
}
add_shortcode( 'jumpmenu', 'jumpmenu' ); 

//[include]
if (is_admin()) {
include dirname(__FILE__) . '/admin.php';
 
} else {
 
function include_shortcode_function($attrs, $content = null) {
 
    if (isset($attrs['file'])) {
        $file = strip_tags($attrs['file']);
        if ($file[0] != '/')
            $file = ABSPATH . $file;
 
        ob_start();
        include($file);
        $buffer = ob_get_clean();
        $options = get_option('includeme', array());
        if (isset($options['shortcode'])) {
            $buffer = do_shortcode($buffer);
        }
    } else {
        $tmp = '';
        foreach ($attrs as $key => $value) {
            if ($key == 'src') {
                $value = strip_tags($value);
            }
            $value = str_replace('&amp;', '&', $value);
            if ($key == 'src') {
                $value = strip_tags($value);
            }
            $tmp .= ' ' . $key . '="' . $value . '"';
        }
        $buffer = '<iframe' . $tmp . '></iframe>';
    }
    return $buffer;
}
 
add_shortcode('include', 'include_shortcode_function');
}



?>