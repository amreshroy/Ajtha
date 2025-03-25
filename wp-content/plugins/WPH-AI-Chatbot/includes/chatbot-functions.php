<?php
function generate_chat_response($last_prompt, &$chat_history, $lead_id) {
$organization_info = esc_textarea(get_option('wph_organization_info', 'No Company Information, Continue with your own knowledge'));
$fallback_value = esc_textarea(get_option('wph_fallback_responses', "I'm sorry, I didn't catch that. Could you rephrase? Feel free to ask something else."));
$api_key = esc_attr(get_option('wph_gemini_api_key', '')); // Use empty string as default if not set

   // Define the starting conversation history
    $default_history = [
    ["role" => "user", "parts" => ["text" => "Hi! I want you to work as an AI assistant for my website. You will be a friendly and smart assistant for our company with good understanding skills. I want you to answer our customers' questions and queries just like a support team member.
I’ll provide you with some important rules and information about our website and company, and based on these, you need to give correct and helpful answers to clients.
Here are the key rules to remember:
Only answer questions related to our business and website.
If you are planning to provide any html elements like links in a tag which uses Double Quote make sure to use in that case use single apostrophe (') so that my final json structure should be valid and also my HTML element get works. for example <a href='links'></a>
If the client’s question is outside our scope, or he is tired or not happy with your answers, politely apologize and simply respond with:  " . $fallback_value . ". Limit each message or answer to a maximum of 10 words; avoid lengthy responses. and for links and other use HTML so the link is clickble and target blank so coustomers can click on it.  
Here are the basic information about our website:, ###" . $organization_info . "###, "]],
		
    ["role" => "model", "parts" => ["text" => "Okay Sure I will follow all your requirements."]]
];

    // Always append the default messages to chat history
    $chat_history = array_merge($default_history, $chat_history);

    // Prepare the API request body with the properly structured chat history
    $body = json_encode(["contents" => $chat_history]);
  //  custom_error_log('API Request Body: ' . $body);

    // API request
    $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . $api_key;
    $response = wp_remote_post($url, [
        'headers' => ['Content-Type' => 'application/json'],
        'body' => $body,
        'timeout' => 120,
    ]);

    // Check for errors in response
    if (is_wp_error($response)) {
        return ['success' => false, 'message' => 'Failed to communicate with the API', 'result' => ''];
    }

    $data = json_decode(wp_remote_retrieve_body($response), true);
 //   custom_error_log('API Response: ' . print_r($data, true));

    // Add AI response to the conversation history if it exists
   if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
    $ai_response = $data['candidates'][0]['content']['parts'][0]['text'];
    $chat_history[] = ["role" => "model", "parts" => ["text" => $ai_response]];

	    // Save the updated conversation history to the database
        save_chat_history_to_db($lead_id, $chat_history);
    return ['success' => true, 'message' => 'Response generated', 'result' => $ai_response];
}


    return ['success' => false, 'message' => 'Unexpected response format', 'result' => ''];
}

function save_chat_history_to_db($lead_id, $chat_history) {
    // Convert chat history to JSON string
    $chat_history_json = json_encode($chat_history);

    // Find the post by lead_id meta
    $args = [
        'post_type' => 'wph_entries',
        'meta_key' => '_lead_id',
        'meta_value' => $lead_id,
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'fields' => 'ids',
    ];
    $posts = get_posts($args);
    if (!empty($posts)) {
        $post_id = $posts[0];
        update_post_meta($post_id, '_chats', $chat_history_json);
		custom_error_log('Post id: ' . $chat_history_json);
    }
}

// Helper function to log custom messages
function custom_error_log($message) {
    $log_file = WP_CONTENT_DIR . '/debugs.log';
    $current_time = date('Y-m-d H:i:s');
    $log_entry = '[' . $current_time . '] ' . $message . PHP_EOL;

    if (file_put_contents($log_file, $log_entry, FILE_APPEND) === false) {
        error_log("Failed to write to log file");
    }
}

function save_bot_entry() {
    // Get the data from the request
    $data = json_decode(file_get_contents('php://input'), true);
    $name = sanitize_text_field($data['name']);
    $email = sanitize_email($data['email']);
    $phone = sanitize_text_field($data['phone']);
    $query = sanitize_textarea_field($data['query']);
    $current_page_url = esc_url($data['current_page_url']);
    $lead_id = sanitize_text_field($data['lead_id']);
    $ip_address = get_user_country();

    // Insert a new post of custom post type "wph_entry"
    $post_id = wp_insert_post([
        'post_type' => 'wph_entries',
        'post_title' => $name, 
        'post_status' => 'publish',
    ]);

    if ($post_id) {
        // Store additional data as post meta
        update_post_meta($post_id, '_lead_id', $lead_id);
        update_post_meta($post_id, '_name', $name);
        update_post_meta($post_id, '_email', $email);
        update_post_meta($post_id, '_phone', $phone);
        update_post_meta($post_id, '_query', $query);
        update_post_meta($post_id, '_chats', ''); // Placeholder for chats
        update_post_meta($post_id, '_user_country', $ip_address);
        update_post_meta($post_id, '_current_page_url', $current_page_url);

        // Send a success response
        wp_send_json_success(['post_id' => $post_id]);
    } else {
        wp_send_json_error(['message' => 'Failed to save entry']);
    }
}
add_action('wp_ajax_save_bot_entry', 'save_bot_entry');
add_action('wp_ajax_nopriv_save_bot_entry', 'save_bot_entry');



function get_user_country() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $api_url = "https://freeipapi.com/api/json/{$ip}";
    $response = wp_remote_get($api_url);
    if (is_wp_error($response)) {
        return '';
    }
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body);
    if (isset($data->countryName)) {
        return $data->countryName; 
    }
    return 'No Country'; 
}

