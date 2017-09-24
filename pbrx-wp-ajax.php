<?php
/**
 * Plugin Name: PBrx WP AJAX Example
 * Plugin URI: https://shellcreeper.com/wp-ajax-for-beginners/
 * Description: Example AJAX plugin using [pbrx-ajax-shortcode]
 * Version: 1.0.1
 * Author: pbrocks
 * Author URI: https://pbrocks.com/
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: pbrx-wp-ajax
 **/

defined( 'ABSPATH' ) || die( 'File cannot be accessed directly' );


add_shortcode( 'pbrx-ajax-shortcode', 'create_shortcode_and_enqueue' );
/**
 * ------------------------------------------
 * 1. REGISTER SHORTCODE
 * ------------------------------------------
 */
function create_shortcode_and_enqueue() {

	/* Enqueue JS only if this shortcode loaded. */
	wp_enqueue_script( 'ajax-script' ); ?>
	<h2><?php esc_attr_e( 'Post Admin Ajax', 'pbrx' ); ?></h2>
	<form id="pbrx-form" action="" method="POST">
		<div>
			<input type="text" name="post-sample" id="post-sample" placeholder="Input post sample" />
			<input type="text" name="post-stuff" id="post-stuff" placeholder="Input post stuff" />
			<input type="button" name="pbrx-submit" id="pbrx_submit" class="button-primary" value="<?php esc_attr_e( 'Sample AJAX Stuff', 'pbrx' ); ?>"/>
			<img src="<?php echo esc_url( admin_url( '/images/wpspin_light.gif' ) ); ?>" class="waiting" id="ptb_loading" style="display:none;"/>
		</div>
	</form>
<p class="test">Wanna test your jQuery.
<button class="test">Test jQuery</button></p><?php 
	/* Output empty div. */
	return '<div id="pbrx-response"></div>';
}


add_action( 'wp_enqueue_scripts', 'register_wp_ajax_scripts' );
/**
 * ------------------------------------------
 * 2. REGISTER SCRIPT
 * ------------------------------------------
 */
function register_wp_ajax_scripts() {

	/* Plugin DIR URL */
	$url = trailingslashit( plugin_dir_url( __FILE__ ) );

	/* JS + Localize */
	wp_register_script( 'ajax-script', $url . 'inc/pbrx-script.js', array( 'jquery' ), '1.0.0', true );
	wp_localize_script( 'ajax-script', 'pbrx_vars', array(
		'pbrx_ajax_url' => admin_url( 'admin-ajax.php' ),
		'pbrx_nonce' =>  wp_create_nonce( 'pbrx-nonce' ),
	) );
}


add_action( 'wp_ajax_pbrx_action', 'pbrx_ajax_function' );
add_action( 'wp_ajax_nopriv_pbrx_action', 'pbrx_ajax_function' );
/**
 * ------------------------------------------
 * 3. AJAX CALLBACK
 * ------------------------------------------
 */
function pbrx_ajax_function() {
	$sample_content = isset( $_POST['sample_content'] ) ? $_POST['sample_content'] : 'N/A';
	$checks_functioning = isset( $_POST['checks_functioning'] ) ? $_POST['checks_functioning'] : 'N/A';
	echo '<pre>';
	print_r( $_POST );
	echo '</pre>';
	?>
	<style type="text/css">
		.show-div {
			text-align: center;
			background-color: aliceblue;
			border: 1px double salmon;
		}
	</style>
	<div class="show-div">
		<h4><?php echo strip_tags( $sample_content ); ?></h4>
		<h4><?php echo strip_tags( $checks_functioning ); ?></h4>
		<h4><?php echo strip_tags( $_POST['start'] ); 
		echo unserialize( $_POST['start'] );
		?></h4>
	</div>
	<?php
	wp_die(); // required. to end AJAX request.
}

