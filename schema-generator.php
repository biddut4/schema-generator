<?php
/**
 * Schema Generator
 *
 * Plugin Name: Schema Generator
 * Plugin URI:  https://wordpress.org/plugins/schema-generator/
 * Description: Enables the WordPress schema generator plugin .
 * Version:     1.0.0
 * Author:      Biddut Rahman
 * Author URI:  https://github.com/biddut4
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: schema-generator
 * Domain Path: /languages
 * Requires at least: 4.9
 * Requires PHP: 5.2.4
 */

 abstract class WPOrg_Meta_Box {


	/**
	 * Set up and add the meta box.
	 */
	public static function add() {
		$screens = [ 'post', 'wporg_cpt' ];
		foreach ( $screens as $screen ) {
			add_meta_box(
				'wporg_box_id',          // Unique ID
				'Custom Meta Box Title', // Box title
				[ self::class, 'html' ],   // Content callback, must be of type callable
				$screen                  // Post type
			);
		}
	}


	/**
	 * Save the meta box selections.
	 *
	 * @param int $post_id  The post ID.
	 */
	public static function save( int $post_id ) {
		if ( array_key_exists( 'wporg_field', $_POST ) ) {
			update_post_meta(
				$post_id,
				'_wporg_meta_key',
				$_POST['wporg_field']
			);
		}
	}


	/**
	 * Display the meta box HTML to the user.
	 *
	 * @param WP_Post $post   Post object.
	 */
	public static function html( $post ) {
		$value = get_post_meta( $post->ID, '_wporg_meta_key', true );
		?>
		<label for="wporg_field">Description for this field</label>
		<select name="wporg_field" id="wporg_field" class="postbox">
			<option value="">Select something...</option>
			<option value="something" <?php selected( $value, 'something' ); ?>>Something</option>
			<option value="else" <?php selected( $value, 'else' ); ?>>Else</option>
		</select>
		<?php
	}
}

add_action( 'add_meta_boxes', [ 'WPOrg_Meta_Box', 'add' ] );
add_action( 'save_post', [ 'WPOrg_Meta_Box', 'save' ] );



?>