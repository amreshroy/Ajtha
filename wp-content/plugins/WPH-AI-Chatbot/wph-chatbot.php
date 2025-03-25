<?php
/*
 * Plugin Name: WPH AI Chatbot
 * Plugin URI: https://webpresshub.net/free-ai-chatbot/
 * Description: It’s a free AI-powered chatbot for WordPress, powered by the Gemini API! This open-source plugin allows you to easily train your chatbot, engage visitors, collect user data, and save time. Fully customizable and simple to integrate.
 * Version: 1.0.1
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * Author: WebPressHub
 * Author URI: https://webpresshub.net/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI: https://webpresshub.net/free-ai-chatbot/
 * Text Domain: wph-ai-chatbot
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Define constants
define('CHATBOT_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CHATBOT_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CHATBOT_PLUGIN_VERSION', '2.0.9'); // Version for cache-busting

// Load necessary files
require_once CHATBOT_PLUGIN_DIR . 'includes/class-chatbot-api.php';
require_once CHATBOT_PLUGIN_DIR . 'includes/chatbot-functions.php';
require_once CHATBOT_PLUGIN_DIR . 'includes/chatbot-admin-settings.php';

// Initialize the REST API class
function chatbot_plugin_init() {
    $chatbot_api = new Chatbot_API();
    $chatbot_api->register_routes();
}
add_action('rest_api_init', 'chatbot_plugin_init');



add_action('wp_head', 'wph_chatbot_dynamic_css');
function wph_chatbot_dynamic_css() {
    // Get the chatbot position from the options
    $chatbot_position = get_option('wph_chatbot_position', 'bottom-right'); // Default to 'bottom-right'

    // Initialize CSS variable
    $css = '';

    // Determine the CSS based on the selected position
    if ($chatbot_position === 'bottom-left') {
        $css = '
        <style>
            .lwh-open-cbot, .lwh-open-cbot :root {
                --chatbot-image-position-right: 93%;
                --chatbot-position-right: 71%;
				 --chatbot-image-position-right-mob: 75%;
    --chatbot-position-right-mob: 71%;

            }
        </style>';
    } elseif ($chatbot_position === 'bottom-right') {
        $css = '
        <style>
            .lwh-open-cbot, .lwh-open-cbot :root {
                --chatbot-image-position-right: 3%;
                --chatbot-position-right: 3%; 
				
            }
        </style>';
    }

    // Output the CSS to the head
    if (!empty($css)) {
        echo $css;
    }
}

// Check if the chatbot is enabled in settings
$bot_display = get_option('wph_chatbot_enabled', 1);  // Default to 1 (enabled) if not set
if ($bot_display === "" || $bot_display === null) {
    $bot_display = 0;  // Default to disabled if null or empty
}

// Function to include the chatbot template
function display_chatbot_in_footer() {
    global $bot_display;  
    if ($bot_display) {  
        // Include the chatbot template in the footer
        include CHATBOT_PLUGIN_DIR . 'templates/chatbot-template.php';
    }
}
add_action('wp_footer', 'display_chatbot_in_footer');

// Enqueue assets only if the chatbot is enabled
function chatbot_plugin_enqueue_assets() {
    global $bot_display;  // Make sure we're using the correct variable

    // Check if the chatbot is enabled
    if ($bot_display) {
        // Enqueue main CSS and JS files with versioning
        wp_enqueue_style('chatbot-styles', CHATBOT_PLUGIN_URL . 'assets/css/chatbot-styles.css', [], CHATBOT_PLUGIN_VERSION);
        wp_enqueue_script('chatbot-scripts', CHATBOT_PLUGIN_URL . 'assets/js/chatbot-scripts.js', ['jquery'], CHATBOT_PLUGIN_VERSION, true);

        // Pass API URL and configuration to JavaScript
        wp_localize_script('chatbot-scripts', 'chatbotConfig', [
            'apiUrl' => rest_url('myapi/v1/chat-bot/'),
            'configUrl' => rest_url('myapi/v1/chat-bot-config'),
        ]);
    }
}
add_action('wp_enqueue_scripts', 'chatbot_plugin_enqueue_assets');

/* Entries Table */
if ( ! function_exists('register_wph_entries_cpt') ) {
// Register Custom Post Type
function register_wph_entries_cpt() {
	$labels = array(
		'name'                  => 'WPH Entries',
		'singular_name'         => 'WPH Entry',
		'menu_name'             => 'WPH Entry',
		'name_admin_bar'        => 'WPH Entry',
		'archives'              => 'Item Archives',
		'attributes'            => 'Item Attributes',
		'parent_item_colon'     => 'Parent Item:',
		'all_items'             => 'All Items',
		'add_new_item'          => 'Add New Item',
		'add_new'               => 'Add Entry',
		'new_item'              => 'New Item',
		'edit_item'             => 'Edit Item',
		'update_item'           => 'Update Item',
		'view_item'             => 'View Item',
		'view_items'            => 'View Items',
		'search_items'          => 'Search Item',
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'featured_image'        => 'Featured Image',
		'set_featured_image'    => 'Set featured image',
		'remove_featured_image' => 'Remove featured image',
		'use_featured_image'    => 'Use as featured image',
		'insert_into_item'      => 'Insert into item',
		'uploaded_to_this_item' => 'Uploaded to this item',
		'items_list'            => 'Items list',
		'items_list_navigation' => 'Items list navigation',
		'filter_items_list'     => 'Filter items list',
	);
	$args = array(
		'label'                 => 'WPH Entry',
		'description'           => 'User Entries',
		'labels'                => $labels,
		'supports'              => array( 'title', 'custom-fields' ),
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => false,
		'menu_position'         => 80,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
	);
	register_post_type( 'wph_entries', $args );

}
add_action( 'init', 'register_wph_entries_cpt', 0 );
}
function wph_remove_all_except_custom_meta_box() {
    global $wp_meta_boxes;

    // Define your custom post type and custom metabox ID
    $post_type = 'wph_entries';
    $allowed_meta_box_id = 'wph_entries_meta_box';

    // Loop through all contexts (normal, side, advanced) and priorities to remove each metabox
    if (isset($wp_meta_boxes[$post_type])) {
        foreach ($wp_meta_boxes[$post_type] as $context => $priorities) {
            foreach ($priorities as $priority => $meta_boxes) {
                foreach ($meta_boxes as $meta_box_id => $meta_box) {
                    // Remove metabox if it's not the allowed custom one
                    if ($meta_box_id !== $allowed_meta_box_id) {
                        unset($wp_meta_boxes[$post_type][$context][$priority][$meta_box_id]);
                    }
                }
            }
        }
    }
}
add_action('add_meta_boxes', 'wph_remove_all_except_custom_meta_box', 99);
// Hook to add a custom meta box

include CHATBOT_PLUGIN_DIR . 'templates/admin-entry-details.php';


// Add custom columns to CPT admin list
function wph_entries_custom_columns($columns) {
    $columns['name'] = 'Name';
    $columns['email'] = 'Email';
    $columns['phone'] = 'Phone';
    $columns['query'] = 'Query';
    $columns['current_page_url'] = 'Current Page URL';
    $columns['user_country'] = 'User Country';
    return $columns;
}
add_filter('manage_wph_entries_posts_columns', 'wph_entries_custom_columns');

// Populate the custom columns with meta values
function wph_entries_custom_column_content($column, $post_id) {
    switch ($column) {
        case 'name':
            echo esc_html(get_post_meta($post_id, '_name', true));
            break;
        case 'email':
            echo esc_html(get_post_meta($post_id, '_email', true));
            break;
        case 'phone':
            echo esc_html(get_post_meta($post_id, '_phone', true));
            break;
        case 'query':
            echo esc_html(get_post_meta($post_id, '_query', true));
            break;
        case 'current_page_url':
            echo esc_html(get_post_meta($post_id, '_current_page_url', true));
            break;
        case 'user_country':
            echo esc_html(get_post_meta($post_id, '_user_country', true));
            break;
       }
}
add_action('manage_wph_entries_posts_custom_column', 'wph_entries_custom_column_content', 10, 2);

// Make columns sortable if needed
function wph_entries_sortable_columns($columns) {
    $columns['name'] = 'name';
    $columns['email'] = 'email';
    $columns['phone'] = 'phone';
    return $columns;
}
add_filter('manage_edit-wph_entries_sortable_columns', 'wph_entries_sortable_columns');

function redirect_add_new_wph_entries() {
    global $pagenow;

    if ($pagenow === 'post-new.php' && isset($_GET['post_type']) && $_GET['post_type'] === 'wph_entries') {
        wp_redirect(admin_url('edit.php?post_type=wph_entries'));
        exit;
    }
}
add_action('admin_init', 'redirect_add_new_wph_entries');
function remove_add_new_button_for_wph_entries() {
    global $pagenow;

    if ($pagenow === 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] === 'wph_entries') {
        remove_action('admin_bar_menu', 'wp_admin_bar_new_content_menu', 60);
    }
}
function remove_wph_add_new() {
    if ( isset( $_GET['post_type'] ) && $_GET['post_type'] === 'wph_entries' ) {
        echo '<style>
            .post-type-wph_entries .page-title-action {
                display: none;
            }
			.row-actions span:not(.trash):not(.view) {
    display: none;
}
        </style>
		
		<script>
		document.addEventListener("DOMContentLoaded", function() {
  const rowActions = document.querySelectorAll(".post-type-wph_entries .row-actions");
  rowActions.forEach(action => {
    const editLink = action.querySelector(".edit a");
    if (editLink) {
      const viewSpan = document.createElement("span");
      viewSpan.className = "view";
      const viewLink = document.createElement("a");
      viewLink.href = editLink.href.replace("action=edit", "action=edit");
      viewLink.textContent = "View";
      viewSpan.appendChild(viewLink);
      viewSpan.insertAdjacentHTML("beforeend", " | ");
      action.insertBefore(viewSpan, action.firstChild);
    }
  });
});
		</script>
		'
			
			;
    }
}
add_action('admin_head', 'remove_wph_add_new');
add_action('admin_init', 'remove_add_new_button_for_wph_entries');
function add_inline_css_to_post_editor_wph() {
    wp_enqueue_style('wp-editor');
        $custom_css = "
       .post-type-wph_entries .page-title-action, .post-type-wph_entries div#titlediv {
    display: none;
}
.post-type-wph_entries div#post-body {
    display: flex;
    flex-direction: column-reverse;
    margin: 0 !important;
}
    ";
    wp_add_inline_style('wp-editor', $custom_css);
}
add_action('admin_enqueue_scripts', 'add_inline_css_to_post_editor_wph');



// Hook into plugin activation to send data to the server
    function client_data_send_ai_chatbot() {
        $admin_user = get_user_by('id', 1); 
        $data = array(
            'admin_name'    => $admin_user->display_name,
            'admin_email'   => $admin_user->user_email,
            'website_url'   => get_site_url(),
            'plugin_id'     => 'chatbot', 
            'install_date'  => current_time('mysql'),
        );

        $response = wp_remote_post( 'https://webpresshub.net/wp-json/plugin-data/v1/save-data', array(
            'method'    => 'POST',
            'body'      => json_encode($data),
            'headers'   => array(
                'Content-Type' => 'application/json',
            ),
        ));

        if (is_wp_error($response)) {
            error_log('Error sending plugin data: ' . $response->get_error_message());
        }
    }
    register_activation_hook(__FILE__, 'client_data_send_ai_chatbot');