<?php
/*
Plugin Name: Carousel Plugin
Plugin URI: http://www.11online.us
Description: Easy way to edit Carousel JS
Version: 1.0
Revision Date: December 16, 2015
License: GNU General Public License 3.0 (GPL) http://www.gnu.org/licenses/gpl.html
Author: Eric Debelak, Josh Garcia
Author URI: http://www.11online.us
*/

define('CAROUSEL_VERSION','1.0');
define('CAROUSEL_NAME','Carousel Plugin');
define('CAROUSEL_ROOT',dirname(__FILE__).'/');
define('CAROUSEL_DIR',basename(dirname(__FILE__)));

// create custom plugin settings menu
add_action('admin_menu', 'carousel_create_menu');

function carousel_create_menu() {
	//create new sub-level menu
	add_submenu_page('options-general.php', 'Carousel Settings', 'Carousel Slider', 'administrator', 'Carousel', 'carousel_settings_page');


	//call register settings function
	add_action( 'admin_init', 'register_carousel_settings' );
}

// enqueue the admin js
function carousel_admin_enqueue($hook) {
	if($hook == 'settings_page_Carousel') {
		wp_enqueue_media();
		wp_enqueue_script( 'settings_page_script', plugin_dir_url( __FILE__ ) . 'views/js/settings.js' );
	}
}
add_action( 'admin_enqueue_scripts', 'carousel_admin_enqueue' );


function register_carousel_settings() {
	//register our settings
	register_setting( 'carousel_settings_group', 'carousel_image_array' );
	register_setting( 'carousel_settings_group', 'carousel_message_array' );
	register_setting( 'carousel_settings_group', 'carousel_link_array' );
	register_setting( 'carousel_settings_group', 'carousel_height' );
}

function carousel_settings_page() {
	// handle settings
  $messages = "";
  if(isset($_POST['carousel_image_array'])) {
      update_option("carousel_image_array", implode("|", $_POST['carousel_image_array']));
      $messages = "Images updated.";
  }
  if(isset($_POST['carousel_message_array'])) {
      update_option("carousel_message_array", implode("|", $_POST['carousel_message_array']));
      $messages .= " Messages updated.";
  }
	if(isset($_POST['carousel_link_array'])) {
      update_option("carousel_link_array", implode("|", $_POST['carousel_link_array']));
      $messages .= " Links updated.";
  }
	if(isset($_POST['carousel_height'])) {
      update_option("carousel_height", $_POST['carousel_height']);
      $messages .= " Height updated.";
  }

	include_once('views/settings.php');
}

add_shortcode('carousel', 'carousel_shortcode_add_code');

function carousel_shortcode_add_code() {

	// add the js and css
	add_action('wp_footer', 'carousel_add_code');

	function carousel_add_code() {
		wp_enqueue_style( 'bootstrap_carousel_style', plugin_dir_url( __FILE__ ) . '/bootstrap/css/bootstrap.css' );
		wp_enqueue_script( 'bootstrap_carousel_script', plugin_dir_url( __FILE__ ) . '/bootstrap/js/bootstrap.min.js', array(), '1.0.0', true );
	}

  $images = get_option("carousel_image_array");
	$images = explode('|', $images);
	$messages = get_option("carousel_message_array");
	$messages = explode('|', $messages);
	$links = get_option("carousel_link_array");
	$links = explode('|', $links);
	$height = get_option("carousel_height");
	$text = '<div id="carousel" class="carousel slide" data-ride="carousel">
	<!-- Indicators -->
	<ol class="carousel-indicators">';
	$count = count($images);
	for($i = 0; $i <  $count; $i++) {
			if($i == 0) {
				$text .= '<li data-target="#carousel" data-slide-to="0" class="active"></li>';
			} else {
				$text .='<li data-target="#carousel" data-slide-to="' . $i . '"></li>';
			}
	}
	$text .= '</ol>
	<!-- Wrapper for slides -->
	<div class="carousel-inner" role="listbox">';
  for($i = 0; $i <  $count; $i++) {
				if($i == 0) {
					$text .= '<a class="item active"';
				} else {
						$text .= '<a class="item"';
				}
	$text .= ' style="background-image: url(' . stripslashes($images[$i]) . '); height: ' . $height . 'px; background-repeat: no-repeat; background-size: cover; background-position: center;" href="' . stripslashes($links[$i]) . '">
			<div class="carousel-caption">
				<h1>' . stripslashes($messages[$i]) . '</h1>
			</div>
	</a>';
	}

	$text .= '</div>
	<!-- Controls -->
	<a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
	<span class="dashicons dashicons-arrow-left-alt2 glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	<span class="sr-only">Previous</span>
	</a>
	<a class="right carousel-control" href="#carousel" role="button" data-slide="next">
	<span class="dashicons dashicons-arrow-right-alt2 glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
	<span class="sr-only">Next</span>
	</a>
	</div>';
	return $text;

}


?>
