<?php
/**
 * Template Name: Sitemap
 *
 *
 * @package WordPress
 * @subpackage GetPixie
 */
header('Content-Type: application/xml; charset=utf-8');
ob_start();
session_start();
global $post;
$pagename = $post->post_name;
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<?php 
	$menu_name = 'primary';
	if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
		$menu = wp_get_nav_menu_object($locations[$menu_name]);
		$menu_items = wp_get_nav_menu_items($menu->term_id);
	}
	foreach ($menu_items as $menu_item) {
		$id = $menu_item->ID;
		$title = $menu_item->title;
		$url = $menu_item->url;
	
	   ?>
		<url>
			<loc><?php echo $url; ?></loc>
			<changefreq>daily</changefreq>
		</url>
	   <?php
	}

?>
<?php 
	$menu_name = 'footer';
	if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
		$menu = wp_get_nav_menu_object($locations[$menu_name]);
		$menu_items = wp_get_nav_menu_items($menu->term_id);
	}
	foreach ($menu_items as $menu_item) {
		$id = $menu_item->ID;
		$title = $menu_item->title;
		$url = $menu_item->url;
	
	   ?>
		<url>
			<loc><?php echo $url; ?></loc>
			<changefreq>daily</changefreq>
		</url>
	   <?php
	}

?>
</urlset>