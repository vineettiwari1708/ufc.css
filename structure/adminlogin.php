Got it. You're using the Buildexo theme, and you've created a new Property section that includes custom filters — separate from the WooCommerce product logic. Now you want to:

✅ Embed a login/registration system, so that
✅ After users register or log in,
✅ They can save "liked" properties to their personal dashboard.

🛠️ Here’s How You Can Implement This:

We’ll break it down into clear steps:

🔧 1. Enable WordPress User Registration

First, make sure WordPress allows users to register:

Go to WP Admin → Settings → General

✅ Check "Anyone can register"

Set New User Default Role to subscriber or something custom.

🧑‍💻 2. Create/Register/Login UI in Frontend

You can use:

Option A: Use a Plugin

Use a frontend user management plugin:

WP User Manager

Ultimate Member

User Registration

These plugins:

Handle login/registration forms

Let you redirect after login/registration

Easily add shortcodes like [user_registration_form]

Option B: Use Custom Forms

Use wp_signon() and wp_create_user() to create a login/registration system manually.

🔐 Example: Custom Registration Form
if ($_POST['register']) {
    $username = sanitize_user($_POST['username']);
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];

    $user_id = wp_create_user($username, $password, $email);
    if (!is_wp_error($user_id)) {
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id);
        wp_redirect('/property-dashboard'); // redirect to user dashboard
        exit;
    }
}

🗂️ 3. Save Liked Properties for Each User

You want logged-in users to like/save properties, and later view them in their dashboard.

You can do this by using user meta to store liked property IDs.

🔖 Example: Save Property to Favorites

You could add a "❤️ Save" button near each property.

HTML Button:
<button class="save-property" data-property-id="123">❤️ Save</button>

JavaScript (AJAX call to save):
jQuery('.save-property').click(function(){
    var propertyId = jQuery(this).data('property-id');

    jQuery.post('/wp-admin/admin-ajax.php', {
        action: 'save_property',
        property_id: propertyId
    }, function(response){
        alert(response.message);
    });
});

PHP: AJAX Handler
add_action('wp_ajax_save_property', 'save_property_ajax');

function save_property_ajax() {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'Please log in first.']);
    }

    $property_id = intval($_POST['property_id']);
    $user_id = get_current_user_id();

    $saved = get_user_meta($user_id, 'saved_properties', true);
    if (!$saved) $saved = [];

    if (!in_array($property_id, $saved)) {
        $saved[] = $property_id;
        update_user_meta($user_id, 'saved_properties', $saved);
    }

    wp_send_json_success(['message' => 'Property saved.']);
}

🧾 4. User Dashboard: View Saved Properties

You can create a "Dashboard" page where logged-in users can view saved properties.

$user_id = get_current_user_id();
$saved = get_user_meta($user_id, 'saved_properties', true);

if ($saved && is_array($saved)) {
    foreach ($saved as $property_id) {
        $post = get_post($property_id);
        echo '<div>';
        echo '<h3>' . esc_html($post->post_title) . '</h3>';
        echo get_the_post_thumbnail($post->ID, 'medium');
        echo '</div>';
    }
} else {
    echo 'No saved properties yet.';
}

🧩 5. Optional: Use Custom Post Type for Properties

If your "Properties" are not using WooCommerce, consider making them a Custom Post Type:

function register_property_post_type() {
    register_post_type('property', [
        'labels' => ['name' => 'Properties'],
        'public' => true,
        'supports' => ['title', 'editor', 'thumbnail'],
        'has_archive' => true,
    ]);
}
add_action('init', 'register_property_post_type');


This lets you:

Query them easily

Use standard WP functions

Add filters, metadata, and custom fields

🧠 Summary of Implementation
Feature	Solution
Frontend registration/login	Use plugin or custom form with wp_create_user() and wp_signon()
Save properties per user	Use update_user_meta() to store liked property IDs
Show dashboard with saved	Retrieve with get_user_meta() and display
Secure with AJAX	Use wp_ajax_* with is_user_logged_in() checks
Post type for properties	Register custom post type for full control
