function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
}

jQuery(document).ready(function ($) {
    jQuery('#register_as_brand').on('click', function(){
        jQuery('input#signup_value').val('RegisterAsBrand');
        jQuery('.landing-page').fadeOut(400);
        jQuery('.landing-page').addClass('hide-panel');
        jQuery('.create-account').fadeIn(400);
        jQuery('.create-account').removeClass('hide-panel');
    });

    jQuery('#register_as_retailer').on('click', function(){
        jQuery('input#signup_value').val('RegisterAsRetailer');
        jQuery('.landing-page').fadeOut(400);
        jQuery('.landing-page').addClass('hide-panel');
        jQuery('.create-account').fadeIn(400);
        jQuery('.create-account').removeClass('hide-panel');
    });

    jQuery('#create_account').on('click', function(){
        jQuery('.create-account').fadeOut(400);
        jQuery('.create-account').addClass('hide-panel');
        jQuery('.privacy-policy').fadeIn(400);
        jQuery('.privacy-policy').removeClass('hide-panel');
    });

    jQuery('#privacy_policy').on('click', function(){
        var checkbox = jQuery('input#agree_terms');
        if (checkbox.is(':checked')) {
            // alert('checked');
            jQuery('.privacy-policy').fadeOut(400);
            jQuery('.privacy-policy').addClass('hide-panel');
            jQuery('.billing-information').fadeIn(400);
            jQuery('.billing-information').removeClass('hide-panel');
        }
    });

    /* jQuery('#registration_form').on('submit', function(e){
        e.preventDefault();
        var $form = $(this);
        $form.serialize();

        jQuery.ajax({           
            url : rml_obj.ajax_url,
            type : 'post',
            data : {
                action : 'custom_action',
            },
            success : function( response ) {
                alert (test);               
                jQuery('#result').html(response);
            }
        });

		$.post(
            $form.attr('action'),
            $form.serialize(),
            function(data) {
			alert('This is data returned from the server ' + data);
		}, 'json');
    }); */
});