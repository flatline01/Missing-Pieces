<?php
/**
 * Template Name: Sub Page Template
 *
 *
 * @package WordPress
 * @subpackage oc4
 */
get_header(); 
global $post;
$pagename = $post->post_name;
$banner = '';
if(get_field('banner_image')){ 
	$banner = ' style="background-image:url(' .	get_field('banner_image') .')"';
}

?>
<div id="main" class="clearafter subpage <?php echo $pagename?>">
	<div class="banner" <?php echo $banner?>>
    	<div class="container">
        	<h1><?php if(get_field('title_text')){echo  get_field('title_text');}  ?></h1>
            <div class="breadcrumbholder">
            <?php the_breadcrumb(); ?>
            </div>
        </div>
    </div>
     <div class="container">
     	<div class="col left">
        	<div class="content">
        	<?php if (have_posts()) : while (have_posts()) : the_post();?>
                <?php the_content(); ?>
            <?php endwhile; endif; ?>
        	</div>
        </div>
        <div class="col right">
	        <?php
                if ($post->post_parent) {
                    $ancestors=get_post_ancestors($post->ID);
                    $root=count($ancestors)-1;
                    $parent = $ancestors[$root];
                } else {
                    $parent = $post->ID;
                }
                
                $children = wp_list_pages("title_li=&child_of=". $parent ."&echo=0&depth=1");
                
                if ($children) { ?>
                <h3>Also in this section...</h3>
                <!--subnav------------------------------->
                <div class="subpagenav">
                    <ul>
                    <?php echo $children; ?>
                    </ul>
                </div>
                <!--/subnav-------------------------------->
                
                <?php } ?>
                <?php dynamic_sidebar( 'subpage_sidebar' ); ?>
        </div>
     </div>
</div>
<?php get_footer();?>