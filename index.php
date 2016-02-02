<?php
/*
Plugin Name: Quote Plugin
Plugin URI: http://www.11online.us
Description: Easy way to edit Carousel JS
Version: 1.0
Revision Date: January 28, 2016
License: GNU General Public License 3.0 (GPL) http://www.gnu.org/licenses/gpl.html
Author: Eric Debelak, Josh Garcia
Author URI: http://www.11online.us
*/

define('QUOTE_VERSION','1.0');
define('QUOTE_NAME','Quote Plugin');
define('QUOTE_ROOT',dirname(__FILE__).'/');
define('QUOTE_DIR',basename(dirname(__FILE__)));

// create custom plugin settings menu
add_action('admin_menu', 'quote_create_menu');

function quote_create_menu() {
	//create new sub-level menu
	add_submenu_page('options-general.php', 'Quote Settings', 'Quote Slider', 'administrator', 'Quote', 'quote_settings_page');


	//call register settings function
	add_action( 'admin_init', 'register_quote_settings' );
}

// enqueue the admin js
function quote_admin_enqueue($hook) {
	if($hook == 'settings_page_Quote') {
		wp_enqueue_media();
		wp_enqueue_script( 'quote_settings_page_script', plugin_dir_url( __FILE__ ) . 'views/js/settings.js' );
		wp_enqueue_script( 'quote_settings_page_script', plugin_dir_url( __FILE__ ) . 'views/js/Sortable.min.js' );
	}
}
add_action( 'admin_enqueue_scripts', 'quote_admin_enqueue' );


function register_quote_settings() {
	//register our settings
	register_setting( 'quote_settings_group', 'quote_message_array' );
}

function quote_settings_page() {
	// handle settings
  $messages = "";
  if(isset($_POST['quote_message_array'])) {
      update_option("quote_message_array", implode("|", $_POST['quote_message_array']));
      $messages .= "Messages updated.";
  }

	include_once('views/settings.php');
}

add_shortcode('quote', 'quote_shortcode_add_code');

function quote_shortcode_add_code() {

	// add the js and css
	add_action('wp_footer', 'quote_add_code');

	function quote_add_code() {
		wp_enqueue_style( 'bootstrap_quote_style', plugin_dir_url( __FILE__ ) . '/bootstrap/css/bootstrap.css' );
		wp_enqueue_script( 'bootstrap_quote_script', plugin_dir_url( __FILE__ ) . '/bootstrap/js/bootstrap.min.js', array(), '1.0.0', true );
	}

	$messages = get_option("quote_message_array");
	$messages = explode('|', $messages);
	$text = '<div id="carousel" class="carousel slide carousel-fade" data-ride="carousel">
	<!-- Indicators -->
	<ol class="carousel-indicators">';
	$count = count($messages);
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
					$text .= '<div class="item active"';
				} else {
						$text .= '<div class="item"';
				}
	$text .= '>
			<div>
				<blockquote>' . stripslashes($messages[$i]) . '</blockquote>
			</div>
	</div>';
	}

	$text .= '</div>';
	return $text;
}


?>
