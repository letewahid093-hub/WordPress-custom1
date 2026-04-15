<?php
/**
 * Twenty Twenty-Four functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Twenty Twenty-Four
 * @since Twenty Twenty-Four 1.0
 */

/* ===============================
   KEEP ALL EXISTING BLOCK STYLES
=================================*/
if ( ! function_exists( 'twentytwentyfour_block_styles' ) ) :
	function twentytwentyfour_block_styles() {
		// ... existing block styles code stays as is ...
	}
endif;
add_action( 'init', 'twentytwentyfour_block_styles' );

if ( ! function_exists( 'twentytwentyfour_block_stylesheets' ) ) :
	function twentytwentyfour_block_stylesheets() {
		// ... existing block stylesheets enqueue code stays as is ...
	}
endif;
add_action( 'init', 'twentytwentyfour_block_stylesheets' );

if ( ! function_exists( 'twentytwentyfour_pattern_categories' ) ) :
	function twentytwentyfour_pattern_categories() {
		register_block_pattern_category(
			'twentytwentyfour_page',
			array(
				'label'       => _x( 'Pages', 'Block pattern category', 'twentytwentyfour' ),
				'description' => __( 'A collection of full page layouts.', 'twentytwentyfour' ),
			)
		);
	}
endif;
add_action('init', 'twentytwentyfour_pattern_categories');


/* ===============================
   EVENTS CUSTOM POST TYPE
=================================*/
function hlftom_create_event_posttype() {
    $labels = array(
        'name' => 'Events',
        'singular_name' => 'Event',
        'add_new' => 'Add Event',
        'add_new_item' => 'Add New Event',
        'edit_item' => 'Edit Event',
        'new_item' => 'New Event',
        'view_item' => 'View Event',
        'view_items' => 'View Events',
        'search_items' => 'Search Events',
        'not_found' => 'No events found',
        'not_found_in_trash' => 'No events found in Trash',
        'all_items' => 'All Events',
        'archives' => 'Event Archives',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-calendar',
        'capability_type' => 'post',
        'supports' => array('title','editor','thumbnail'),
    );

    register_post_type('event', $args);
}
add_action('init', 'hlftom_create_event_posttype');


/* ===============================
   CUSTOM META BOXES FOR EVENTS
=================================*/
function hlftom_add_event_meta_boxes() {
    add_meta_box(
        'event_details',             // ID
        'Event Details',             // Title
        'hlftom_event_meta_box_html',// Callback
        'event',                     // Post type
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'hlftom_add_event_meta_boxes');

function hlftom_event_meta_box_html($post) {
    $date = get_post_meta($post->ID, '_event_date', true);
    $location = get_post_meta($post->ID, '_event_location', true);
    ?>
    <label for="event_date">Date:</label>
    <input type="date" name="event_date" id="event_date" value="<?php echo esc_attr($date); ?>" /><br><br>

    <label for="event_location">Location:</label>
    <input type="text" name="event_location" id="event_location" value="<?php echo esc_attr($location); ?>" />
    <?php
}


/* ===============================
   SAVE EVENT META DATA
=================================*/
function hlftom_save_event_meta($post_id) {
    if (array_key_exists('event_date', $_POST)) {
        update_post_meta($post_id, '_event_date', sanitize_text_field($_POST['event_date']));
    }
    if (array_key_exists('event_location', $_POST)) {
        update_post_meta($post_id, '_event_location', sanitize_text_field($_POST['event_location']));
    }
}
add_action('save_post', 'hlftom_save_event_meta');
function hlftom_load_styles() {
    wp_enqueue_style(
        'event-style',
        get_stylesheet_uri()
    );
}
add_action('wp_enqueue_scripts','hlftom_load_styles');
?>