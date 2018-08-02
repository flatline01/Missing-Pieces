<?php
/**
 * Template Name: Sub Page Template with subsections
 *
 *
 * @package WordPress
 * @subpackage GetPixie
 */





get_header(); 
global $post;
$pagename = $post->post_name;

?>
<div class="subpage <?php echo $pagename?>">
    <div id="banner">
        <div class="header">
            <h1><?php if(get_field('page_header')){echo get_field('page_header');}  ?></h1>
        </div>
        <?php
			$img ="";
			if(get_field('subpage_banner')){$img = get_field('subpage_banner');}  
			//else{$img = get_template_directory_uri() . '/images/default_subpagebanner.jpg';}
			?>
        <div class="bannerimage" style="background-image:url(<?php echo $img ?>);"></div>
    </div>
    <!--subpage content-->
    <div class="contentwrapper navtrigger">
<?php 
	if (have_posts()) : while (have_posts()) : the_post();
	the_content();
	//get subpages as sections of content
	//$pages = get_pages('child_of='.$post->ID.'&sort_order=desc&orderby=menu_order&parent='.$post->ID);
	$pages = get_pages('child_of='.$post->ID.'&sort_column=menu_order&orderby=menu_order&parent='.$post->ID);
	$count = 0;
	foreach($pages as $page) {
			$template = get_post_meta( $page->ID, '_wp_page_template', true );
			$template = pathinfo($template);
			$template_parts = explode('-', $template['filename']);
		
		?>
		<section class="<?php echo $page->post_name ." " .$template_parts[1] . " section".$count ?> " id="<?php echo $page->post_name?>">
			<?php echo file_get_contents(get_page_link($page->ID));	?>    
		</section>
	<?php 
		$count ++;
	}
	endwhile; endif; 

?>
	</div>
    <!--/subpage content-->   
</div>
<?php get_footer();?>