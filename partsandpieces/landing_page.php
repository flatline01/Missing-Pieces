<?php
/**
 * Template Name: Landing Page
 *
 *
 * @package WordPress
 * @subpackage GetPixie
 */

get_header(); 
?>
<div class="subpage landing <?php echo $post->post_name  ?>">
<!--Landing page-->
<style>
<?php if(get_field('landing_css')){echo get_field('landing_css');} ?>
</style>
<script>
	mixpanel.track_links(".video.play", "Play Video");
</script>
	<?php
        $img ="";
        if(get_field('subpage_banner')){$img = get_field('subpage_banner');}  
        //else{$img = get_template_directory_uri() . '/images/default_subpagebanner.jpg';}
    ?>
    <div class="header landing clearafter" style="background-image:url(<?php echo $img ?>);">
    	<a href="//www.youtube.com/embed/3hXfZNL9Zq4" class="lightbox video play" target="_blank"><span class="icon"></span><span class="label">Watch it work</span></a>
        <div class="container">
        	<div class="content">
        		<?php if(get_field('landing_banner_content')){echo get_field('landing_banner_content');} ?>
            </div>
        </div>
    </div>
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
    <!--/landing page content-->   
</div>
<?php get_footer();?>