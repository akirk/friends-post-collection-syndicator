<?php
/**
 * Plugin name: Friends Post Collection Syndicator
 * Plugin author: Alex Kirk
 * Plugin URI: https://github.com/akirk/friends-post-collection-syndicator
 * Version: 0.1
 *
 * Description: Send friend posts to your e-reader.
 *
 * License: GPL2
 * Text Domain: friends-post-collection Syndicator
 * Domain Path: /languages/
 *
 * @package Friends_Post_Collection Syndicator
 */

/**
 * This file contains the main plugin functionality.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'friends_post_collection syndicator', '__return_true' );
add_action( 'users_edit_post_collection_table_end', function( $user ) {
	$feed = $user->get_local_friends_page_url() . 'feed/';
	?>
	<tr>
		<th><label for="url"><?php esc_html_e( 'Syndicate Posts' ); ?></label></th>
		<td>
			<fieldset>
				<input type="checkbox"> Publish this Post Collection at <a href="<?php echo esc_url( $feed ); ?>"><?php echo esc_url( $feed ); ?></a>
			</fieldset>
		</td>
	</tr>
	<?php
} );
