<?php
/*

@package sunsetTheme

==============================
THEME CUSTOM TYPES
==============================
*/


$contact = get_option('activate_contact');
// @ symbol checks if the variable is not empty
if ( @$contact == 1 ){
    add_action( 'init', 'sunset_contact_custom_post_type' );

    // the' manage_...._posts_columns' part is always static, the 'sunset-contact' is the name of the custom post that we want to edit
    add_filter( 'manage_sunset-contact_posts_columns', 'sunset_set_contact_columns' );
    add_action( 'manage_sunset-contact_posts_custom_column', 'sunset_contact_custom_column', 10, 2 );

    add_action('add_meta_boxes', 'sunset_contact_add_meta_box');
    //save content in db
    add_action('save_post', 'sunset_save_contact_email_data');
};

// CONTACT CPT 
function sunset_contact_custom_post_type(){
    $labels = array(
        'name'              => 'Messages',
        'singular_name'     => 'Message',
        'menu_name'         => 'Messages',
        'name_admin_bar'    => 'Message'
    );

    $args = array(
        'labels'            =>  $labels,
        'show_ui'           =>  true,
        'show_in_menu'      =>  true,
        'capability_type'   =>  'post',
        'hierarchical'      =>  false,
        'menu_position'     =>  26,
        'menu_icon'         =>  'dashicons-email-alt',
        'supports'          =>  array( 'title', 'editor', 'author')
    );

    register_post_type( 'sunset-contact', $args );

};

function sunset_set_contact_columns( $columns ){
    // the columns variable has all the types of the columns that we can add like the ones at $args['support']
    $newColumns = array();
    $newColumns['title'] = 'Full Name';
    $newColumns['message'] = 'Message';
    $newColumns['email'] = 'Email';
    $newColumns['date'] = 'Date';
    return $newColumns;

}

//to show the content inside the columns
function sunset_contact_custom_column( $column, $post_id ){
    switch( $column ){
        case 'message' :
            echo get_the_excerpt();
            break;
        case 'email' :
            //email column
            $email = get_post_meta( $post_id, '_contact_email_value_key', true );
            echo '<a href="mailto:'.$email.'">'.$email.'</a>';
            break;

    
            
    }
}

// CONTACT META BOXES
function sunset_contact_add_meta_box(){
    add_meta_box( 'contact_email', 'User Email', 'sunset_contact_email_callback', 'sunset-contact', 'side' );
}

function sunset_contact_email_callback( $post ){
    //prebuild wp function that generates a unic id to check if the action is legit,  to avoid hackers
    wp_nonce_field( 'sunset_save_contact_email_data', 'sunset_contact_email_meta_box_nonce' );

    $value = get_post_meta( $post->ID, '_contact_email_value_key', true );

    echo '<label for="sunset_contact_email_field"> Email Address </label>';
    echo '<input type="email" id="sunset_contact_email_field" name="sunset_contact_email_field" value="' . esc_attr( $value ) .'" size="25"/>';
}

function sunset_save_contact_email_data( $post_id ){
    /* Important security tests before saving the email address */

    //if the nonce is not set then stop function
    if( ! isset( $_POST['sunset_contact_email_meta_box_nonce'] ) ){
        return;
    }
    //if the nonce is not valid, takes 2 params, first is the actual nonce id, and 2nd is the function that saves the metabox, which is this same function
    if( ! wp_verify_nonce( $_POST['sunset_contact_email_meta_box_nonce'], 'sunset_save_contact_email_data' ) ) {
        return;
    }
    //check is this is autosave(revisions),  we don't need autosave for saving email address (this is optional)
    if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
        return;
    }
    //does this user have the permission to do this change?
    if( ! current_user_can( 'edit_post', $post_id ) ){
        return;
    }
    // if the input is not set, no need to save
    if ( ! isset( $_POST['sunset_contact_email_field'])){
        return;
    }
    //sanitize the data and put in var
    $my_data = sanitize_text_field( $_POST['sunset_contact_email_field'] );
    //save the data in db
    update_post_meta( $post_id, '_contact_email_value_key', $my_data );

}