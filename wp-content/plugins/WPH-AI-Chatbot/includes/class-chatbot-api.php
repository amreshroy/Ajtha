<?php
class Chatbot_API {

    public function register_routes() {
        register_rest_route('myapi/v1', '/chat-bot/', [
            'methods' => 'POST',
            'callback' => [$this, 'handle_chat_bot_request'],
            'permission_callback' => '__return_true'
        ]);

        register_rest_route('myapi/v1', '/chat-bot-config', [
            'methods' => 'GET',
            'callback' => [$this, 'load_chat_bot_base_configuration'],
        ]);
    }

    public function handle_chat_bot_request(WP_REST_Request $request) {
        $last_prompt = $request->get_param('last_prompt');
        $conversation_history = $request->get_param('conversation_history');
		$lead_id = $request->get_param('lead_id');

        if (!is_array($conversation_history)) $conversation_history = [];

        $response = generate_chat_response($last_prompt, $conversation_history, $lead_id);
        return new WP_REST_Response($response, 200);
    }

   public function load_chat_bot_base_configuration(WP_REST_Request $request) {
    // Retrieve all settings
    $bot_status = get_option('wph_chatbot_enabled', 1);
if ($bot_status === "" || $bot_status === null) {
    $bot_status = 0; 
}
    $startup_message = get_option('wph_welcome_message', 'Hi, How are you?');
    $font_size = '16'; 
    $user_avatar_url = get_option('wph_user_image', plugin_dir_path('assets/images/user-avatar.png', __FILE__));
    $bot_image_url = get_option('wph_bot_image', plugin_dir_path('assets/images/bot-logo.png', __FILE__));

    // Button queries
    $buttons = [];
    $button_options = [
        'wph_button_1_query',
        'wph_button_2_query',
        'wph_button_3_query',
        'wph_button_4_query',
        'wph_button_5_query',
    ];

    // Loop through button options and add to buttons array if set
    foreach ($button_options as $option_name) {
        $button_text = get_option($option_name, '');
        if (!empty($button_text)) {
            $buttons[] = [
                'buttonText' => $button_text,
                'buttonPrompt' => $button_text
            ];
        }
    }

    // Return response with dynamic values
    return new WP_REST_Response([
        'botStatus' => $bot_status,
        'StartUpMessage' => $startup_message,
        'fontSize' => $font_size,
        'userAvatarURL' => $user_avatar_url,
        'botImageURL' => $bot_image_url,
        'commonButtons' => $buttons
    ], 200);
}

}