<h1>Sunset Sidebar Options</h1>
<?php
//Displays settings errors registered by add_settings_error() .
settings_errors(); ?>
<?php
    $picture = esc_attr( get_option('profile_picture') );
    $firstName = esc_attr( get_option('first_name') );
    $lastName = esc_attr( get_option('last_name') );
    $fullName = $firstName .' '. $lastName;
    $description = esc_attr( get_option('user_description') );
?>

<div class="sunset-sidebar-preview">
    <div class="sunset-sidebar">
        <div class="image-container">
            <div id="profile-picture-preview" class="profile-picture" style="background-image: url(<?php print $picture; ?>)"></div>
        </div>
        <h1 class="sunset-username"><?php  print $fullName ?></h1>
        <h2 class="sunset-description"><?php print $description ?></h2>
        <div class="icon-wrapper">

        </div>
    </div>
</div>

<!--options.php is the page that handles all the data we entered and updates the db -->
<form method="post" action="options.php" class="sunset-general-form">
    <?php
    //Outputs nonce, action, and option_page fields for a settings page.
    //A settings group name. This should match the group name used in register_setting() .
    settings_fields('sunset-settings-group'); ?>
    <?php
    //Prints out all settings sections added to a particular settings page.
    //params is the slug name of the page whose settings sections you want to output.
    do_settings_sections('webproz-sunset'); ?>
    <?php submit_button('Save Changes', 'primary', 'btnSubmit'); ?>
</form>