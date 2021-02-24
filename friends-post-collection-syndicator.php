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
				<input type="checkbox" name="publish_post_collection" value="1" <?php checked( get_user_option( 'friends_publish_post_collection', $user->ID ) ); ?> /> Publish this Post Collection at <a href="<?php echo esc_url( $feed ); ?>"><?php echo esc_url( $feed ); ?></a>
			</fieldset>
		</td>
	</tr>
	<?php
} );

add_action( 'friends_edit_post_collection_after_form_submit', function( $user ) {
	if ( isset( $_POST['publish_post_collection'] ) && $_POST['publish_post_collection'] ) {
		update_user_option( $user->ID, 'friends_publish_post_collection', true );
	} else {
		delete_user_option( $user->ID, 'friends_publish_post_collection' );
	}
} );

add_filter( 'friends_friend_feed_viewable', function( $viewable, $author_login ) {
	$author = get_user_by( 'login', $author_login );
	if ( get_user_option( 'friends_publish_post_collection', $author->ID ) && $author->has_cap( 'post_collection' ) ) {
		add_filter( 'pre_option_rss_use_excerpt', '__return_true', 30 );
		return true;
	}
	return $viewable;
}, 10, 2 );
