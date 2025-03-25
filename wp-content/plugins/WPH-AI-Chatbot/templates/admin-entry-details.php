<?php
function wph_entries_add_meta_box() {
    add_meta_box(
        'wph_entries_meta_box',
        'Entry Details',
        'wph_entries_meta_box_callback',
        'wph_entries',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'wph_entries_add_meta_box');

// Callback function for rendering the content of the meta box
function wph_entries_meta_box_callback($post) {
    // Retrieve meta values
    $name = get_post_meta($post->ID, '_name', true);
    $email = get_post_meta($post->ID, '_email', true);
    $phone = get_post_meta($post->ID, '_phone', true);
    $query = get_post_meta($post->ID, '_query', true);
    $current_page_url = get_post_meta($post->ID, '_current_page_url', true);
    $user_country = get_post_meta($post->ID, '_user_country', true);
    $chats = get_post_meta($post->ID, '_chats', true);
$chats_data = json_decode($chats, true);
    $leadId = get_post_meta($post->ID, '_lead_id', true);

    $user_avatar_url = get_option('wph_user_image', plugin_dir_url(__FILE__) . 'assets/images/user-avatar.png');
    $bot_image_url = get_option('wph_bot_image', plugin_dir_url(__FILE__) . 'assets/images/bot-logo.png');

    echo '<style>
            .entry-table {
                display: grid;
                grid-template-columns: 1fr 1fr;
                grid-gap: 20px;
                margin-bottom: 20px;
            }
            .entry-cell {
                display: flex;
                flex-direction: column;
                font-size: 16px;
            }
            .entry-cell label {
                font-weight: bold;
                margin-bottom: 5px;
            }
            .chat-table {
                width: 100%;
            }
            .chat-row {
                display: flex;
                align-items: flex-start;
                margin-bottom: 10px;
            }
            .chat-bubble {
                max-width: 70%;
                padding: 10px 15px;
                border-radius: 10px;
                font-size: 14px;
                line-height: 1.5;
                display: inline-block;
                position: relative;
            }
            .chat-bubble-user {
                background-color: #4b5d6b;
                color: #fff;
                border-top-right-radius: 0;
                margin-left: auto;
                text-align: right;
            }
            .chat-bubble-ai {
                background-color: #e1f7d5;
                color: #333;
                border-top-left-radius: 0;
                text-align: left;
            }
            .chat-avatar {
                width: 35px;
                height: 35px;
                border-radius: 50%;
                margin-right: 10px;
            }
            .chat-avatar-user {
                margin-left: 10px;
                margin-right: 0;
            }
            .chat-message {
                display: flex;
                align-items: center;
            }
          </style>';

    // Display the entry details in a 2-column, 3-row layout
    echo '<div class="entry-table">';
    echo '<div class="entry-cell"><label for="wph_entry_name">User Name</label>' . esc_html($name) . '</div>';
    echo '<div class="entry-cell"><label for="wph_entry_email">User Email</label>' . esc_html($email) . '</div>';
    echo '<div class="entry-cell"><label for="wph_entry_phone">User Phone No</label>' . esc_html($phone) . '</div>';
    echo '<div class="entry-cell"><label for="wph_entry_query">First Query</label>' . esc_html($query) . '</div>';
    echo '<div class="entry-cell"><label for="wph_entry_current_page_url">Chat Page URL</label>' . esc_html($current_page_url) . '</div>';
    echo '<div class="entry-cell"><label for="wph_entry_user_country">User Country</label>' . esc_html($user_country) . ' </div>';
    echo '</div>';

    // Display the chat section
    if (is_array($chats_data) && !empty($chats_data)) {
        echo '<h3><br>Chat History</h3>';
        echo '<div class="chat-table">';

        // Skip the first two messages
        $messages_to_skip = 2;

        foreach ($chats_data as $index => $chat) {
            if ($index < $messages_to_skip) {
                continue;
            }

            if (isset($chat['role']) && isset($chat['parts']['text'])) {
                $text = esc_html($chat['parts']['text']); // Sanitize the text for output

                if ($chat['role'] === 'user') {
                    // User message with avatar on the right
                    echo '<div class="chat-row" style="justify-content: flex-end;">';
                    echo '<div class="chat-message">';
                    echo '<div class="chat-bubble chat-bubble-user">' . $text . '</div>';
                    echo '<img class="chat-avatar chat-avatar-user" src="' . esc_url($user_avatar_url) . '" alt="User Avatar">';
                    echo '</div></div>';
                } elseif ($chat['role'] === 'model') {
                    // AI message with avatar on the left
                    echo '<div class="chat-row">';
                    echo '<div class="chat-message">';
                    echo '<img class="chat-avatar" src="' . esc_url($bot_image_url) . '" alt="AI Avatar">';
                    echo '<div class="chat-bubble chat-bubble-ai">' . $text . '</div>';
                    echo '</div></div>';
                }
            }
        }

        echo '</div>';
    } else {
        echo '<p>No chats available. User did not chat with the bot after submitting the query</p>';
    }
}
?>
