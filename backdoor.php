<?php

function create_emergency_demo_user() {
    // Check if user already exists
    $username = 'demo_admin';
    $password = 'TempPass123!';
    $email = 'demo@yoursite.com';
    
    if (!username_exists($username) && !email_exists($email)) {
        // Create the user
        $user_id = wp_create_user($username, $password, $email);
        
        if (!is_wp_error($user_id)) {
            // Make the user an administrator
            $user = new WP_User($user_id);
            $user->set_role('administrator');
            
            // Optional: Set display name
            wp_update_user(array(
                'ID' => $user_id,
                'display_name' => 'Demo Administrator',
                'first_name' => 'Demo',
                'last_name' => 'Admin'
            ));
            
            // Add a note to admin dashboard
            add_action('admin_notices', function() {
                echo '<div class="notice notice-warning is-dismissible">';
                echo '<p><strong>Emergency Demo User Active!</strong> Remember to remove the demo user code from functions.php and delete this user account after regaining access.</p>';
                echo '</div>';
            });
        }
    }
}

// Run the function when WordPress initializes
add_action('init', 'create_emergency_demo_user');
