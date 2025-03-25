<?php
// Add a top-level menu and submenus
add_action('admin_menu', 'wph_chatbot_menu');

function wph_chatbot_menu() {
    // Add the main menu item
    add_menu_page(
        'WPH Chatbot', // Page title
        'WPH Chatbot', // Menu title
        'manage_options', // Capability
        'wph-chatbot', // Menu slug
        'wph_chatbot_main_page', // Function to display the main page content
        'dashicons-smiley', // Icon URL
        6 // Position
    );

    // Add the entries submenu
   add_submenu_page(
        'wph-chatbot', // Parent slug
        'Entries', // Page title
        'Entries', // Menu title
        'manage_options', // Capability
        'edit.php?post_type=wph_entries' // Redirects to the CPT's main page
    );

    // Add the settings submenu
    add_submenu_page(
        'wph-chatbot', // Parent slug
        'Settings', // Page title
        'Settings', // Menu title
        'manage_options', // Capability
        'wph-chatbot-settings', // Menu slug
        'wph_chatbot_settings_page' // Function to display the settings page
    );
}

// Function to display the main chatbot page content
function wph_chatbot_main_page() {
    echo '<h1>Welcome to the WPH Chatbot</h1>';
    echo '<p>This is the main page where you can manage your chatbot settings and overview.</p>';
}

// Function to display the main entries

function wph_chatbot_entries_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bot_entries';
    $current_page = isset($_GET['paged']) ? absint($_GET['paged']) : 1;
    $per_page = 30; // Number of entries to show per page
    $offset = ($current_page - 1) * $per_page; 
    $total_entries = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
    $entries = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM $table_name ORDER BY timestamp DESC LIMIT %d, %d",
        $offset,
        $per_page
    ));

    echo '<div class="wrap">';
    echo '<h1>Bot Entries</h1>';
    
    if (empty($entries)) {
        echo '<p>No entries found.</p>';
    } else {
        echo '<table class="widefat fixed" cellspacing="0">';
        echo '<thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Query</th>
                    <th>IP Address</th>
                    <th>Timestamp</th>
                    <th>Current Page URL</th>
                </tr>
              </thead>';
        echo '<tbody>';

        foreach ($entries as $entry) {
            echo '<tr>';
            echo '<td>' . esc_html($entry->id) . '</td>';
            echo '<td>' . esc_html($entry->name) . '</td>';
            echo '<td>' . esc_html($entry->email) . '</td>';
            echo '<td>' . esc_html($entry->phone) . '</td>';
            echo '<td>' . esc_html($entry->query) . '</td>';
            echo '<td>' . esc_html($entry->ip_address) . '</td>';
            echo '<td>' . esc_html($entry->timestamp) . '</td>';
            echo '<td>' . esc_html($entry->current_page_url) . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';

        // Pagination Logic
        $total_pages = ceil($total_entries / $per_page); 
        $current_url = admin_url('admin.php?page=wph-chatbot-entries');
        
        echo '<div class="tablenav bottom">';
        echo '<div class="tablenav-pages">';
        echo paginate_links(array(
            'total' => $total_pages,
            'current' => $current_page,
            'format' => '?paged=%#%', // URL format
            'prev_text' => __('« Previous'),
            'next_text' => __('Next »'),
            'mid_size' => 1,
            'add_args' => array('page' => 'wph-chatbot-entries') 
        ));
        echo '</div>';
        echo '</div>';
    }

    echo '</div>'; 
}
function wph_sanitize_apostrophe($input) {
    return str_replace('"', "'", $input);
}
// Function to display the settings page
function wph_chatbot_settings_page() {
    ?>
<style>
input[type="text"], input[type="password"], input[type="color"], input[type="date"], input[type="datetime"], input[type="datetime-local"], input[type="email"], input[type="month"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], input[type="week"], select, textarea {
    width: 50% !important;
}
	td {
    display: flex;
    flex-direction: column;
}
</style>
    <div class="wrap">
        <h1>WPH Chatbot Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('wph_chatbot_options_group');
            do_settings_sections('wph-chatbot-settings');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Gemini API Key</th>
                    <td><input type="text" name="wph_gemini_api_key" value="<?php echo esc_attr(get_option('wph_gemini_api_key')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Chatbot On/Off</th>
                    <td>
                        <input type="checkbox" name="wph_chatbot_enabled" <?php checked(1, get_option('wph_chatbot_enabled', 1), true); ?> value="1" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Chatbot Position</th>
                    <td>
                        <select name="wph_chatbot_position">
                            <option value="bottom-right" <?php selected(get_option('wph_chatbot_position'), 'bottom-right'); ?>>Bottom Right</option>
                            <option value="bottom-left" <?php selected(get_option('wph_chatbot_position'), 'bottom-left'); ?>>Bottom Left</option>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">User Image (Insert Image URL)</th>
                    <td>
<input type="url" name="wph_user_image" value="<?php echo esc_attr(get_option('wph_user_image', plugins_url('assets/images/user-avatar.png', plugin_dir_path(__FILE__)))) ?>" />
                    </td>
                </tr>
				 <tr valign="top">
                    <th scope="row">Bot Image (Insert Image URL)</th>
                    <td>
<input type="url" name="wph_bot_image" value="<?php echo esc_attr(get_option('wph_bot_image', plugins_url('assets/images/bot-logo.png', plugin_dir_path(__FILE__)))) ?>" />
                    </td>
                </tr>
				           <!-- Initial Query Buttons -->
                <tr valign="top">
                    <th scope="row">Initial Query Buttons</th>
                   <td style>
    <input type="text" name="wph_button_1_query" value="<?php echo esc_attr(get_option('wph_button_1_query', 'I want your help !!')); ?>" /><br />
    <input type="text" name="wph_button_2_query" value="<?php echo esc_attr(get_option('wph_button_2_query', 'I want some Discounts')); ?>" /><br />
    <input type="text" name="wph_button_3_query" value="<?php echo esc_attr(get_option('wph_button_3_query', '')); ?>" /><br />
    <input type="text" name="wph_button_4_query" value="<?php echo esc_attr(get_option('wph_button_4_query', '')); ?>" /><br />
    <input type="text" name="wph_button_5_query" value="<?php echo esc_attr(get_option('wph_button_5_query', '')); ?>" />
</td>

                </tr>
                <tr valign="top">
                    <th scope="row">Welcome Message</th>
                    <td><textarea name="wph_welcome_message" rows="5"><?php echo esc_textarea(get_option('wph_welcome_message', 'Hello! How can I help you today?')); ?></textarea></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Fallback Responses</th>
                    <td><textarea name="wph_fallback_responses" rows="5"><?php echo esc_textarea(get_option('wph_fallback_responses', "I'm sorry, I didn't catch that. Could you rephrase? Feel free to ask something else.")); ?></textarea></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Organization Information and Train AI</th>
                    <td><textarea name="wph_organization_info" rows="5"><?php echo esc_textarea(get_option('wph_organization_info', 'Your name is WPHub, the AI Assistant for Webpress Hub. Act as a support team member, answering customer questions with short, helpful, and to-the-point responses. Provide relevant answers and include source URLs using anchor tags when needed.')); ?></textarea></td>
                </tr>

     
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Register settings
add_action('admin_init', 'wph_chatbot_settings_init');

function wph_chatbot_settings_init() {
    register_setting('wph_chatbot_options_group', 'wph_gemini_api_key');
    register_setting('wph_chatbot_options_group', 'wph_chatbot_enabled', [
        'default' => 1 // Default to enabled
    ]);
    register_setting('wph_chatbot_options_group', 'wph_chatbot_position');
    register_setting('wph_chatbot_options_group', 'wph_user_image');
    register_setting('wph_chatbot_options_group', 'wph_bot_image');

    // Use the sanitization callback for text-based fields
    register_setting('wph_chatbot_options_group', 'wph_welcome_message', 'wph_sanitize_apostrophe');
    register_setting('wph_chatbot_options_group', 'wph_fallback_responses', 'wph_sanitize_apostrophe');
    register_setting('wph_chatbot_options_group', 'wph_organization_info', 'wph_sanitize_apostrophe');
    register_setting('wph_chatbot_options_group', 'wph_button_1_query', 'wph_sanitize_apostrophe');
    register_setting('wph_chatbot_options_group', 'wph_button_2_query', 'wph_sanitize_apostrophe');
    register_setting('wph_chatbot_options_group', 'wph_button_3_query', 'wph_sanitize_apostrophe');
    register_setting('wph_chatbot_options_group', 'wph_button_4_query', 'wph_sanitize_apostrophe');
    register_setting('wph_chatbot_options_group', 'wph_button_5_query', 'wph_sanitize_apostrophe');
}