/* jQuery('#landing_form').on('submit', function(e){
    alert('hello');
    var signup_value = $("#signup_value").val();
    $.ajax({ 
        data: {
            action: 'contact_form',
            signup_value: signup_value
        },
        type: 'post',
        url: ajaxurl,
        success: function(data) {
            console.log(data);
        }
    });
}); */

jQuery(document).ready(function($) {
    "use strict";
    $('#registration_form').submit( function( event ) {
        event.preventDefault(); // Prevent the default form submit.

        var ajax_form_data = $(this).serialize();
        //ajax_form_data = ajax_form_data + '&ajaxrequest=true&submit=Submit+Form';

        $.ajax({
            url:    params.ajaxurl,
            type:   'post',
            data:   ajax_form_data
        })
        .done( function( response ) { // response from the PHP action
            $(".message").html( '<p class="success msg">The request was successful </p>');
        })
        .fail( function() {
            $(".message").html( '<p class="error msg">Something went wrong.</p>' );                  
        })
        // after all this time?
        .always( function() {
            event.target.reset();
        });
    });
});