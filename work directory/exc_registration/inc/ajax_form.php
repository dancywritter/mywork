<?php
add_action('wp_ajax_contact_form', 'contact_form');
add_action('wp_ajax_nopriv_contact_form', 'contact_form');

function contact_form() {
   var_dump( $_POST );

   //when a form is submitted to admin-post.php
    $this->loader->add_action( 'admin_post_nds_form_response', $plugin_admin, 'the_form_response');
    //when a form is submitted to admin-ajax.php
    $this->loader->add_action( 'wp_ajax_nds_form_response', $plugin_admin, 'the_form_response');
}

function the_form_response() {
    if( isset( $_POST['ajaxrequest'] ) && $_POST['ajaxrequest'] === 'true' ) {
        // server response
        echo '<pre>';					
          print_r( $_POST );
        echo '</pre>';				
        wp_die();
    }
}