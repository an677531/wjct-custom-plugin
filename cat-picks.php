<?php
/**
 * Plugin Name: Cat Picks
 * Description: Creates a custom post type called Cat Picks with a new custom field called "Featured By".
 * Author: Anthony Zarczynski
 */

/**
 * Register the Cat Picks custom post type.
 */
function cat_picks_register_post_type() {
    register_post_type( 'cat_picks', array(
        'labels' => array(
            'name'          => 'Cat Picks',
            'singular_name' => 'Cat Pick',
            'add_new_item'  => 'Add New Cat Pick',
            'edit_item'     => 'Edit Cat Pick',
            'view_item'     => 'View Cat Pick',
        ),
        'public'        => true,
        'has_archive'   => true,
        'show_in_rest'  => true,
        'supports'      => array( 'title', 'editor', 'thumbnail' ),
        'menu_icon'     => 'dashicons-pets',
    ));
}
add_action( 'init', 'cat_picks_register_post_type' );

/**
 * Add a custom meta field called "Featured By" to the new post type. This field displays the text input preceeded by "Featured By:" once it is rendered on the front end with the cat_picks_display_featured_by function.
 */
function cat_picks_register_meta() {
    register_post_meta( 'cat_picks', 'featured_by', array(
        'show_in_rest'  => true,
        'single'        => true,
        'type'          => 'string',
        'auth_callback' => function() {
            return current_user_can( 'edit_posts' );
        },
    ));
}
add_action( 'init', 'cat_picks_register_meta' );

/**
 * Add the Featured By meta box to the Cat Picks edit screen.
 */
function cat_picks_add_meta_box() {
    add_meta_box(
        'cat_picks_featured_by',
        'Featured By',
        'cat_picks_meta_box_html',
        'cat_picks',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'cat_picks_add_meta_box' );

/**
 * Render the Featured By meta box input field.
 */
function cat_picks_meta_box_html( $post ) {
    $value = get_post_meta( $post->ID, 'featured_by', true );
    wp_nonce_field( 'cat_picks_save_meta', 'cat_picks_nonce' );
    ?>
    <label for="featured_by">Featured By</label>
    <input
        type="text"
        id="featured_by"
        name="featured_by"
        value="<?php echo esc_attr( $value ); ?>"
        style="width:100%;"
    />
    <?php
}

/**
 * Save the Featured By meta field when the post is saved.
 */
function cat_picks_save_meta( $post_id ) {
    // Verify nonce
    if ( ! isset( $_POST['cat_picks_nonce'] ) ||
         ! wp_verify_nonce( $_POST['cat_picks_nonce'], 'cat_picks_save_meta' ) ) {
        return;
    }
    // Don't save on autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    // Check permissions
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    // Sanitize and save
    if ( isset( $_POST['featured_by'] ) ) {
        update_post_meta(
            $post_id,
            'featured_by',
            sanitize_text_field( $_POST['featured_by'] )
        );
    }
}
add_action( 'save_post', 'cat_picks_save_meta' );

/**
 * Display the Featured By value on the front end
 * when viewing a single Cat Pick.
 */
function cat_picks_display_featured_by( $content ) {
    if ( is_singular( 'cat_picks' ) && in_the_loop() ) {
        $featured_by = get_post_meta( get_the_ID(), 'featured_by', true );
        if ( $featured_by ) {
            $content .= '<p class="cat-picks-featured-by"><strong>Featured By:</strong> '
                . esc_html( $featured_by )
                . '</p>';
        }
    }
    return $content;
}
add_filter( 'the_content', 'cat_picks_display_featured_by' );