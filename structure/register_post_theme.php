It sounds like you are trying to use a template (such as a pre-built Elementor template or a default theme template) in the sidebar of a page, but you're not seeing the option to select one in the page editor.

Let’s break down the solution into two steps: ensuring Elementor templates are accessible and configuring the theme's sidebar.

1. Ensure Elementor Templates Are Accessible

If you're trying to display an Elementor template inside the sidebar or content area, you need to ensure the following:

a. Elementor Template

First, make sure you have created an Elementor template (e.g., for a property or a page layout).

Go to Elementor > Templates in your WordPress admin area and make sure you've created a template.

If you're using the theme's default templates or Elementor templates, make sure Elementor is properly integrated with your theme (it looks like you have that part already set up from the code you provided).

b. Elementor Template Shortcode

You can use Elementor’s shortcode feature to load Elementor templates in any section of your website (including sidebars).

Get the Elementor Template Shortcode:

Open the Elementor > Templates page.

Find the template you want to use and note its ID.

You can use the following shortcode format to display the template in the sidebar or page content:

[elementor-template id="TEMPLATE_ID"]

Replace TEMPLATE_ID with the ID of your Elementor template.

Add the Elementor Template Shortcode in the Sidebar Widget:

Go to Appearance > Widgets.

Drag the Text or Custom HTML widget into the sidebar.

Paste the shortcode [elementor-template id="TEMPLATE_ID"] into the widget.

c. Enable Elementor to Load the Template

To make sure Elementor is fully integrated into your theme:

You should check if Elementor is enabled for all post types. If it's not, add this code to your functions.php file:

function enable_elementor_for_all_post_types($elementor_post_types) {
    $elementor_post_types[] = 'property'; // Add your custom post type if needed
    return $elementor_post_types;
}
add_filter('elementor/post/types', 'enable_elementor_for_all_post_types');

2. Theme Default Templates for Sidebar (if using default theme templates)

If you're not using Elementor templates but want to use default theme templates in the sidebar, here’s how you can handle that:

a. Register and Display Widgets or Templates in Sidebar

If you want to include a default page template or a theme template in the sidebar, you can add custom widgets or page templates.

For example, you can create a custom widget or sidebar template like this:

Add a Custom Sidebar Template (e.g., a "Property Details" template):

In your theme's functions.php, you can create a custom widget that loads a page template or any predefined content in the sidebar.

function register_custom_sidebar_template() {
    register_sidebar(array(
        'name' => __('Custom Sidebar', 'theme-textdomain'),
        'id' => 'custom-sidebar',
        'before_widget' => '<div class="sidebar-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ));
}
add_action('widgets_init', 'register_custom_sidebar_template');


Add the Sidebar Template to Your Theme:

If you have a specific sidebar template file (like sidebar-property.php), you can include that in your page template like this:

// Inside page templates or property single page
get_sidebar('property'); // This will call sidebar-property.php or default sidebar.php if not found.


Add Widgets or Page Templates:

Go to Appearance > Widgets and add the custom widget you’ve created, or select a page template if your theme supports that functionality.

3. Configure the Page Template Selector in the Sidebar

If you want to display a template in the sidebar for pages, you should ensure that your theme or the page editor allows you to select templates.

a. Page Template Selection

To add a custom template to a page in WordPress:

Open the page editor for the page you want to modify.

In the Page Attributes section on the right side of the editor, you should see a Template dropdown. You can select a template here if one has been registered in the theme.

To register a custom template for pages:

// Register a custom page template
function register_custom_page_template($templates) {
    $templates['template-property.php'] = 'Property Template'; // Add your custom template here
    return $templates;
}
add_filter('theme_page_templates', 'register_custom_page_template');


This will allow you to choose Property Template when editing a page.

4. Common Troubleshooting Tips

Clear Cache: If the changes are not reflecting immediately, clear the browser and server cache.

Theme Compatibility with Elementor: Some themes might override certain Elementor functionalities. Make sure your theme supports full Elementor integration. If it doesn’t, you can use the default Elementor Canvas or Full Width template to bypass any theme interference.

Rebuild the Page: Sometimes when you add a new template or sidebar, you may need to rebuild the page or refresh Elementor to ensure it’s fully integrated.

Summary

For Elementor Templates: Use the Elementor shortcode [elementor-template id="TEMPLATE_ID"] inside a Text or HTML widget in the sidebar.

For Default Theme Templates: Register custom sidebars and widgets, and make sure your page template is available for selection in the Page Attributes section of the page editor.

This should allow you to add either Elementor templates or theme default templates to your page or sidebar. Let me know if you need further assistance!
