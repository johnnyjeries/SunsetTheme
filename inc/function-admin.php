<?php
/*

@package sunsetTheme

==============================
ADMIN PAGE
==============================
*/

function sunset_add_admin_page(){
    /* adds menu new menu option for wordpress dashboard
    first parameter 'sunset theme options' is the page title that appears in the header seciton of the page after we click
    second 'Sunset' is the name that appears on the sidebar
    third is the capability, meaning which user level has access to this page
    fourth is the slug that appears for this page, should use - when naming it, best to have one word or 2 words connected with underscore _  and not dash -
    fifth is the function that is responsible for the generation of the page
    sixth is the icon url (must be png or svg)
    seventh is to specify the position of our menu
    */
    //Generate sunset admin page
    add_menu_page( 'Sunset Theme Options', 'Sunset', 'manage_options', 'webproz_sunset', 'sunset_theme_create_page','', 110 );
    //Generate sunset admin subpages
    add_submenu_page('webproz_sunset', 'Sunset Sidebar Options', 'Sidebar', 'manage_options', 'webproz_sunset', 'sunset_theme_create_page');
    add_submenu_page('webproz_sunset', 'Sunset Theme Options', 'Theme Options', 'manage_options', 'webproz_sunset_theme', 'sunset_theme_support_page');
    add_submenu_page('webproz_sunset', 'Sunset CSS Options', 'Custom CSS', 'manage_options', 'webproz_sunset_css', 'sunset_theme_settings_page');
    add_submenu_page('webproz_sunset', 'Sunset Contact Form', 'Contact Form', 'manage_options', 'webproz_sunset_theme_contact', 'sunset_contact_form_page');
    /*
    1st parameter is the parents name which is in this case 'webproz_sunset'
    page title
    menu title
    capability
    slug name
    callback function
    */

    //Activate custom settings
    add_action('admin_init', 'sunset_custom_settings');
    //action is located inside the function so it is called only when we are generating the admin page
};

function sunset_custom_settings(){
    //Sidebar Options Settings
    register_setting('sunset-settings-group', 'profile_picture');
    register_setting('sunset-settings-group', 'first_name');
    register_setting('sunset-settings-group', 'last_name');
    register_setting('sunset-settings-group', 'user_description');
    register_setting('sunset-settings-group', 'twitter_handler', 'sunset_sanitize_twitter_handler');
    register_setting('sunset-settings-group', 'facebook_handler');
    register_setting('sunset-settings-group', 'gplus_handler');
    //usually for the names they use dash for the group of fields, and underscore for the single field
    /* creates a specific section in the db to record a custom groups of settings/fields
    1st unic name for the information
    2nd option name, the name of specific single option
    3rd callback function
    */

    add_settings_section('sunset-sidebar-options', 'Sidebar Options', 'sunset_sidebar_options', 'webproz-sunset');
    // creates a specific section to store all the fields like inputs
    /* 1st is the ID
    2nd is the title
    3rd par is callback function
    4rd is the page where we want the fields applied to
    */

    add_settings_field('sidebar-profile-picture', 'Profile Picture', 'sunset_sidebar_profile', 'webproz-sunset', 'sunset-sidebar-options');
    add_settings_field('sidebar-name', 'Full Name', 'sunset_sidebar_name', 'webproz-sunset', 'sunset-sidebar-options');
    add_settings_field('sidebar-desc', 'Description', 'sunset_sidebar_desc', 'webproz-sunset', 'sunset-sidebar-options');
    add_settings_field('sidebar-twitter', 'Twitter Handler', 'sunset_sidebar_twitter', 'webproz-sunset', 'sunset-sidebar-options');
    add_settings_field('sidebar-facebook', 'Facebook Handler', 'sunset_sidebar_facebook', 'webproz-sunset', 'sunset-sidebar-options');
    add_settings_field('sidebar-google', 'Google+ Handler', 'sunset_sidebar_gplus', 'webproz-sunset', 'sunset-sidebar-options');

    //Theme Support Options
    register_setting( 'sunset-theme-support', 'post_formats');
    register_setting( 'sunset-theme-support', 'custom_header');
    register_setting( 'sunset-theme-support', 'custom_background');

    add_settings_section( 'sunset-theme-options', 'Theme Options', 'sunset_theme_options', 'webproz_sunset_theme' );
    
    add_settings_field('post-formats', 'Post Formats', 'sunset_post_formats', 'webproz_sunset_theme', 'sunset-theme-options' );
    add_settings_field('custom-header', 'Custom Header', 'sunset_custom_header', 'webproz_sunset_theme', 'sunset-theme-options' );
    add_settings_field('custom-background', 'Custom Background', 'sunset_custom_background', 'webproz_sunset_theme', 'sunset-theme-options' );

    //Contact Form Options
    register_setting( 'sunset-contact-options', 'activate_contact' );

    add_settings_section( 'sunset-contact-section', 'Contact Form', 'sunset_contact_section', 'webproz_sunset_theme_contact' );

    add_settings_field( 'activate-form', 'Activate Contact Form', 'sunset_activate_contact', 'webproz_sunset_theme_contact', 'sunset-contact-section');

    // Custom CSS options
    register_setting( 'sunset-custom-css-options', 'sunset_css' );
    add_settings_section( 'sunset-custom-css-section', 'Custom CSS', 'sunset_custom_css_section_callback', 'webproz_sunset_css' );
    add_settings_field( 'custom-css', 'Insert Your Custom CSS', 'sunset_custom_css_callback', 'webproz_sunset_css', 'sunset-custom-css-section' );
}


function sunset_custom_css_section_callback(){
    echo "Customize Sunset Theme with your own CSS";
}

function sunset_custom_css_callback(){
    //collect all the different post formats that wp comes with
    $css = get_option('sunset_css');
    $css = ( empty($css) ? '/* Sunset Theme Custom CSS */' : $css );
    echo '<textarea placeholder="Sunset Custom CSS"> '.$css.' </textarea>';
}

function sunset_contact_section(){
    echo "Activate or deactivate the Built-in Contact Form";
}

function sunset_theme_options(){
    echo "Activate or deactivate some options here";
}

function sunset_post_formats(){
    //collect all the different post formats that wp comes with
    $options = get_option('post_formats');
    $formats = array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat');
    $output = '';
    foreach ( $formats as $format ){
        $checked = ( @$options[$format] == 1 ? 'checked' : '' );
        $output .= '<label><input type="checkbox" id="' .$format. '" name="post_formats[' .$format. ']" ' .$checked. ' value="1" /> '.$format.'</label><br>';
    }
    echo $output;
}

function sunset_custom_header(){
    //collect all the different post formats that wp comes with
    $options = get_option('custom_header');
    $checked = ( @$options[$format] == 1 ? 'checked' : '' );
    echo '<label><input type="checkbox" id="custom_header" name="custom_header"' .$checked. ' value="1" /> Activate The Custom Header</label><br>';
}

function sunset_activate_contact(){
    //collect all the different post formats that wp comes with
    $options = get_option('activate_contact');
    $checked = ( @$options[$format] == 1 ? 'checked' : '' );
    echo '<label><input type="checkbox" id="activate_contact" name="activate_contact"' .$checked. ' value="1" /> Activate The Contact Form</label><br>';
}

function sunset_custom_background(){
    //collect all the different post formats that wp comes with
    $options = get_option('custom_background');
    $checked = ( @$options[$format] == 1 ? 'checked' : '' );
    echo '<label><input type="checkbox" id="custom_background" name="custom_background"' .$checked. ' value="1" /> Activate The Custom Background</label><br>';
}

//Sidebar Options Functions
function sunset_sidebar_options(){
    echo 'Customize your Sidebar Information';
}

function sunset_sidebar_profile(){
    $picture = esc_attr( get_option('profile_picture') );
    if ( empty( $picture )){
        echo '<input type="button" class="button button-secondary" name="profile_picture" value="Upload Profile Picture" id="upload-button"/> <input type="hidden" id="profile-picture" name="profile_picture" value="' .$picture. '"/>';
    } else {
        echo '<input type="button" class="button button-secondary" name="profile_picture" value="Replace Profile Picture" id="upload-button"/> <input type="hidden" id="profile-picture" name="profile_picture" value="' .$picture. '"/> <input type="button" class="button button-secondary" name="profile_picture" value="Remove Profile Picture" id="remove-button"/>';
    }

}
function sunset_sidebar_name(){
    $firstName = esc_attr( get_option('first_name') );
    $lastName = esc_attr( get_option('last_name') );
    echo '<input type="text" name="first_name" placeholder="First Name" value="' .$firstName. '"/> <input type="text" name="last_name" placeholder="Last Name" value="' .$lastName. '"/>';
}
function sunset_sidebar_desc(){
    $description = esc_attr( get_option('user_description') );
    echo '<input type="text" name="user_description" placeholder="User Description" value="' .$description. '"/>';
}
function sunset_sidebar_twitter(){
    $twitter = esc_attr( get_option('twitter_handler') );
    echo '<input type="text" name="twitter_handler" placeholder="Twitter Handler" value="' .$twitter. '"/>';
}
function sunset_sidebar_facebook(){
    $facebook = esc_attr( get_option('facebook_handler') );
    echo '<input type="text" name="facebook_handler" placeholder="Facebook Handler" value="' .$facebook. '"/>';
}
function sunset_sidebar_gplus(){
    $gplus = esc_attr( get_option('gplus_handler') );
    echo '<input type="text" name="gplus_handler" placeholder="Google+ Handler" value="' .$gplus. '"/>';
}

//Sanitization Settings
function sunset_sanitize_twitter_handler( $input ){
    $output = sanitize_text_field($input);
    $output = str_replace('@', '', $output);
    return $output;
}



//Actions are the hooks that the WordPress core launches at specific points during execution, or when specific events occur. Plugins can specify that one or more of its PHP functions are executed at these points, using the Action API.
//Hooks are functions that can be applied to an action or filter in WordPress.
//Action hooks allow developers to execute custom code at specific points in the WordPress execution process, while filter hooks allow developers to modify the output or behavior of a WordPress function by changing its parameters or returning a modified value.
add_action('admin_menu', 'sunset_add_admin_page');

//Template submenu functions
function sunset_theme_create_page(){
    //function for generation of the admin page
    //no need to require the file multiple times
    require_once( get_template_directory() . '/inc/templates/sunset-admin.php' );

};

function sunset_theme_support_page(){
    require_once( get_template_directory() . '/inc/templates/sunset-theme-support.php');
}

function sunset_contact_form_page(){
    require_once( get_template_directory() . '/inc/templates/sunset-contact-form.php');
}

function sunset_theme_settings_page(){
    require_once( get_template_directory() . '/inc/templates/sunset-custom-css.php' );
}