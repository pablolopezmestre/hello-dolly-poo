<?php

/**
 * Plugin Name:       Hello Dolly POO
 * Description:       Hello Dolly orientado a objetos.
 * Version:           1.0.0
 * Author:            Pablo López
 * Author URI:        https://desarrollowp.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       hello-dolly-poo
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'PLUGIN_NAME_VERSION', '1.0.0' );

class Hello_Dolly_Poo {
	private static $instance = null;

	public function __construct() {
		$this->define_admin_hooks();
	}

	protected function __clone() {
		// No Clones!
	}

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function define_admin_hooks() {
		// Now we set that function up to execute when the admin_notices action is called
		add_action( 'admin_notices', array( $this, 'hello_dolly' ) );

		// We need some CSS to position the paragraph
		add_action( 'admin_enqueue_scripts', array( $this, 'dolly_css' ) );
	}

	public function hello_dolly() {
		$chosen = $this->hello_dolly_get_lyric();

		echo '<p id="dolly-poo">' . $chosen . '</p>';
	}

	public function dolly_css() {
		// This makes sure that the positioning is also good for right-to-left languages
		$x = is_rtl() ? 'left' : 'right';

		wp_enqueue_style( 'hello-dolly-poo', plugin_dir_url( __FILE__ ) . 'assets/hello-dolly-poo.css' );
       	$custom_css = "#dolly-poo{
       		float: $x;
			padding-$x: 15px;
        }";
        wp_add_inline_style( 'hello-dolly-poo', $custom_css );
	}

	private function hello_dolly_get_lyric() {
		/** These are the lyrics to Hello Dolly */
		$lyrics = "Hello, Dolly
		Well, hello, Dolly
		It's so nice to have you back where you belong
		You're lookin' swell, Dolly
		I can tell, Dolly
		You're still glowin', you're still crowin'
		You're still goin' strong
		We feel the room swayin'
		While the band's playin'
		One of your old favourite songs from way back when
		So, take her wrap, fellas
		Find her an empty lap, fellas
		Dolly'll never go away again
		Hello, Dolly
		Well, hello, Dolly
		It's so nice to have you back where you belong
		You're lookin' swell, Dolly
		I can tell, Dolly
		You're still glowin', you're still crowin'
		You're still goin' strong
		We feel the room swayin'
		While the band's playin'
		One of your old favourite songs from way back when
		Golly, gee, fellas
		Find her a vacant knee, fellas
		Dolly'll never go away
		Dolly'll never go away
		Dolly'll never go away again";

		// Here we split it into lines
		$lyrics = explode( "\n", $lyrics );

		// And then randomly choose a line
		return wptexturize( $lyrics[ mt_rand( 0, count( $lyrics ) - 1 ) ] );
	}
}

Hello_Dolly_Poo::instance();
