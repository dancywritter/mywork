<?php
function exc_landing_page( $atts ) {
    $a = shortcode_atts( array(
        'form_name'         => 'Create Account',
        'form_img'          => plugins_url( 'assets/images/screen.png', dirname(__FILE__) ), //plugin_dir_url( __FILE__ ) . '/assets/images/screen.png',
        'video_id'          => 'rw0y2V-gvN4',
        'colored_title'     => 'Welcome to ',
        'site_name'         => 'exchangecollective.com',
        'text_paragraph'    => 'Suspendisse massa nulla volutpat dictum aliquam faucibus at dui duis non leo.',
        'billing_name'      => 'Billing Info',
        'terms_title'       => 'Terms and Conditions',
    ), $atts );
    
    //[exc_form form_name="Create Account" form_img="" video_id="rw0y2V-gvN4" colored_title="Welcome to " site_name="exchangecollective.com" text_paragraph="Suspendisse massa nulla volutpat dictum aliquam faucibus at dui duis non leo." billing_name="Billing Info" terms_title="Terms and Conditions"]

    $img = plugins_url( 'assets/images/logo.png', dirname(__FILE__));
    
    $formImg = '';
    if(!empty($a['form_img'])) {
        $formImg = 'style="background-image: url('. $a['form_img'] .');"';
    } else {
        $formImg = '';
    }
    $val = $_REQUEST['signup_value'];

    $coloredImg = plugins_url( 'assets/images/logo-colored.png', dirname(__FILE__));
    
    // action="'. admin_url('admin-ajax.php') .'"
    $html = '
    <form name="registration_form" id="registration_form" method="post">
        <div class="registration-form landing-page billing">
            <div class="container">
                <img src="'. $img .'" alt="Logo">
                <div class="inner-landing-page">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-registration left-panel">
                                <ul>
                                    <li>
                                        <input id="register_as_brand" type="button" value="Register Brand" class="primary-btn">
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-registration right-panel">
                                <ul>
                                    <li>
                                        <input id="register_as_retailer" type="button" value="Register Retailer" class="primary-btn">
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="signup_value" id="signup_value" value="brand">
                </div>
            </div>
        </div>
        <div class="registration-form create-account hide-panel">
            <div class="container">
                <div class="row">
                    <div class="col-md-7 col-sm-7 col-xs-12">
                        <div class="welcome-area">
                            <div class="video-img" '. $formImg .'>
                                <div class="visible-mobile">
                                    <img src="'. $a['form_img'] .'" alt="">
                                </div>
                                <div class="video">
                                    <iframe width="100%" height="100%" src="https://www.youtube.com/embed/'. $a['video_id'] .'?controls=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                            </div>
                            <div class="welcome-text">
                                <h1>'. $a['colored_title'] .'<span>'. $a['site_name'] .'</span></h1>
                                <p>'. $a['text_paragraph'] .'</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <div class="form-registration">
                            <h2>'. $a['form_name'] .'</h2>
                            <ul>
                                <li>
                                    <label for="brand_name">Brand Name</label>
                                    <input type="text" name="brand_name" id="brand_name">
                                </li>
                                <li>
                                    <label for="username">User Name</label>
                                    <input type="text" name="username" id="username">
                                </li>
                                <li>
                                    <label for="company_name">Company Name</label>
                                    <input type="text" name="company_name" id="company_name">
                                </li>
                                <li>
                                    <label for="email_address">Email Address</label>
                                    <input type="text" name="email_address" id="email_address">
                                </li>
                                <li>
                                    <label for="phone_number">Phone Number</label>
                                    <input type="text" name="phone_number" id="phone_number">
                                </li>
                                <li>
                                    <label for="first_name">First Name</label>
                                    <input type="text" name="first_name" id="first_name">
                                </li>
                                <li>
                                    <label for="last_name">Last Name</label>
                                    <input type="text" name="last_name" id="last_name">
                                </li>
                                <li>
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password">
                                </li>
                                <li>
                                    <label for="confirm_password">Confirm Password</label>
                                    <input type="password" name="confirm_password" id="confirm_password">
                                </li>
                                <li>
                                    <input type="button" id="create_account" value="Continue" class="primary-btn">
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="privacy-policy fullwidth hide-panel">
            <div class="top-strip">
                <img src="'. $coloredImg .'" alt="Logo">
            </div>
            <div class="page-title-area">
                <div class="container">
                    <h2>'. $a['terms_title'] .'</h2>
                </div>
            </div>
            <div class="terms-condition">
                <div class="row">
                    <div class="container">
                        <div class="inner-container">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <h3>Introduction</h3>
                                    <p>Maecenas pharetra rhoncus dignissim. Fusce ornare, eros non maximus malesuada, urna nisi dapibus risus, a dignissim orci nulla id odio duis vitae lobortis
                                    magna. Aliquam lorem sem, rutrum quis lorem ac, luctus tincidunt massa. Nullam sit amet malesuada orci. Praesent fermentum, mauris at pretium element
                                    libero odio dapibus sapien, eu condimentum lectus augue at ex. Vivamus et ipsum a augue mollis porta a aliquet lacus. Maecenas vitae augue mattis, dignis
                                    lorem quis, sodales tellus. Duis lobortis eu odio eu ultricies. Maecenas at ultricies libero.</p>
                                    <p><strong>Condimentum lectus augue at ex. Vivamus et ipsum a augue mollis porta a aliquet lacus. Maecenas vitae augue mattis, dignissim lorem quis, sodales tellus. Duis lobortis eu odio eu ultricies. Maecenas at ultricies libero. Fusce scelerisque mattis justo eget pulvinar.</strong></p>
                                    <p>Ut vel ipsum gravida, aliquet enim sed, dapibus eros. Sed vestibulum diam ut dictum tempus. Etiam ac quam vitae tortor malesuada fermentum. Phasellus nec tempor purus, et ultrices turpis. Sed nec leo diam. Maecenas vulputate a elit non bibendum. Nulla euismod nulla tincidunt diam scelerisque dapibus. Morbi volutpat nec ante vel ultrices. Quisque a augue id ex consequat dignissim vel vel lacus. Integer elit enim, sagittis ut urna et, facilisis gravida enim. Morbi id congue dolor, vitae pharetra lacus. Nulla eu fermentum mauris. Aliquam pretium sem molestie posuere ultricies. Curabitur lectus lectus, aliquet sed ligula accumsan, porta sollicitudin sapien. Nam tincidunt sagittis leo vitae accumsan.</p>
                                    <p><strong>Condimentum lectus augue at ex vivamus et ipsum a augue mollis porta a aliquet lacus maecenas vitae augue mattis dignissim lorem quis.</strong></p>
                                    <h3>Terms of Service</h3>
                                    <p>Sed pretium eleifend mauris id aliquet. Aliquam erat volutpat. Donec aliquet est sed lectus convallis maximus. Proin varius metus et urna faucibu, scelerisque quam placerat. Nam venenatis, eros elementum malesuada euismod, erat mauris lacinia magna, ut ultricies massa sapien sit amet purus. In quis tristique tellus. Fusce eu iaculis nisi. Morbi in pellentesque quam, et consectetur lorem.</p>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porta eu est ac dapibus. Suspendisse et orci rhoncus, faucibus eros ac, sodales elit. Curabitur vitae elementum nisi. Donec sed ultrices purus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis tortor dolor, cursus vitae vulputate ut, gravida sit amet sapien. Morbi et pellentesque justo, vestibulum consequat ligula. Aenean nec diam quam. Fusce vel rutrum orci, vel iaculis nunc. Nam dignissim tortor ut orci vehicula ornare.</p>
                                    <p><strong>Condimentum lectus augue at ex. Vivamus et ipsum a augue mollis porta a aliquet lacus. Maecenas vitae augue mattis, dignissim lorem quis, sodales tellus. Duis lobortis eu odio eu ultricies. Maecenas at ultricies libero. Fusce scelerisque mattis justo eget pulvinar.</strong></p>
                                    <h3>Motivations:</h3>
                                    <p>Sed pretium eleifend mauris id aliquet. Aliquam erat volutpat. Donec aliquet est sed lectus convallis maximus. Proin varius metus et urna faucibu, scelerisque quam placerat. Nam venenatis, eros elementum malesuada euismod, erat mauris lacinia magna, ut ultricies massa sapien sit amet purus. In quis tristique tellus. Fusce eu iaculis nisi. Morbi in pellentesque quam, et consectetur lorem.</p>
                                    <div class="submit-area">
                                        <div class="row">
                                            <div class="col-md-6 col-xs-12">
                                                <div class="radio">
                                                    <input type="checkbox" name="agree_terms" id="agree_terms">
                                                    <label for="agree_terms">I agreed to terms and conditions</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-12">
                                                <input type="button" id="privacy_policy" class="primary-btn pull-right" value="Continue">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="registration-form billing-information billing hide-panel">
            <div class="container">
                <img src="'. $img .'" alt="Logo">
                <div class="inner-billing-form">
                    <div class="message"></div>
                    <h2>'. $a['billing_name'] .'</h2>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-registration left-panel">
                                <ul>
                                    <li>
                                        <label for="billing_address1">Billing Address Line 1</label>
                                        <input type="text" name="billing_address1" id="billing_address1" required>
                                    </li>
                                    <li>
                                        <label for="billing_address2">Billing Address Line 2</label>
                                        <input type="text" name="billing_address2" id="billing_address2" required>
                                    </li>
                                    <li>
                                        <label for="city">City</label>
                                        <input type="text" name="city" id="city" required>
                                    </li>
                                    <li>
                                        <label for="state">State</label>
                                        <input type="text" name="state" id="state" required>
                                    </li>
                                    <li>
                                        <label for="zipcode">Zip</label>
                                        <input type="text" name="zipcode" id="zipcode" required>
                                    </li>
                                    <li>
                                        <label for="country">Country</label>
                                        <input type="text" name="country" id="country" required>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-registration right-panel">
                                <ul>
                                    <li>
                                        <h3>Payment Option</h3>
                                        <div class="radio">
                                            <input type="radio" name="payment_option" id="payment_option1">
                                            <label for="payment_option">$29/month Paid Annually only $348.<br>
                                            Get additional 3 months (15/mo for price of 12/mo)</label>
                                        </div>
                                        <div class="radio">
                                            <input type="radio" name="payment_option" id="payment_option2">
                                            <label for="payment_option">30 days free then $49/mo cancel anytime</label>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="#" class="secondary-btn">Compare Pricing</a>
                                    </li>
                                    <li>
                                        <h3 class="credit-card-title">Credit Card Information</h3>
                                    </li>
                                    <li>
                                        <label for="name_on_card">Name On Card</label>
                                        <input type="text" name="name_on_card" id="name_on_card">
                                    </li>
                                    <li>
                                        <label for="credit_card_number">Credit Card Number</label>
                                        <input type="text" name="credit_card_number" id="credit_card_number">
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="col-md-6 col-xs-12">
                                                <label for="expiry_date">Expiration Date</label>
                                                <input type="text" name="expiry_date" id="expiry_date">
                                            </div>
                                            <div class="col-md-6 col-xs-12">
                                                <label for="security_code">Security Code</label>
                                                <input type="text" name="security_code" id="security_code">
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <input type="hidden" name="action" value="custom_action">
                                        <input type="submit" value="Continue" id="submition_form" class="primary-btn">
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>';

    return $html;
}
add_shortcode( 'exc_form', 'exc_landing_page' );

add_action( 'wp_ajax_custom_action', 'custom_action' );
add_action( 'wp_ajax_nopriv_custom_action', 'custom_action' );
function custom_action() {
    // A default response holder, which will have data for sending back to our js file
    $response = array(
        'success' => true,
        'data' => $_POST
    );
    
    $accountType = '';
    if( $_POST['signup_value'] === 'RegisterAsBrand' ) {
        $accountType = '1';
    } else {
        $accountType = '4';
    }
    
    $agreement = '';
    if( $_POST['agree_terms'] === 'on' ) {
        $agreement = 'true';
    } else {
        $agreement = 'false';
    }

    $user = $_POST["username"];
    $mail = $_POST["email_address"];
    $comName = $_POST["company_name"];
    $phone = $_POST["phone_number"];
    $bname = $_POST["brand_name"];
    $fname = $_POST["first_name"];
    $lname = $_POST["last_name"];
    $pass = $_POST["password"];
    $cpass = $_POST["confirm_password"];
    $agree = $_POST["agree_terms"];
    $billAddr1 = $_POST["billing_address1"];
    $billAddr2 = $_POST["billing_address2"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $zipcode = $_POST["zipcode"];
    $country = $_POST["country"];
    $payment_option = $_POST["payment_option"];
    $cardName = $_POST["name_on_card"];
    $cardNmbr = $_POST["credit_card_number"];
    $cardexp = $_POST["expiry_date"];
    $cardcvv = $_POST["security_code"];

    $formData = '{
                    "email":"'. $mail .'",
                    "password":"'. $pass .'",
                    "password2":"'. $cpass .'",
                    "companyName":"'. $comName .'",
                    "accountType":"'. $accountType .'",
                    "brandName":"'. $bname .'",
                    "address":"'. $billAddr1 .'",
                    "address2":"'. $billAddr2 .'",
                    "city":"'. $city .'",
                    "state":"'. $state .'",
                    "country":"'. $country .'",
                    "zip":"'. $zipcode .'",
                    "firstName":"'. $fname .'",
                    "lastName":"'. $lname .'",
                    "title":"'. $cpass .'",
                    "phoneNumber":"'. $phone .'",
                    "username":"'. $user .'",
                    "agreed":"'. $agreement .'"
                }';
    /* echo '<pre>';
    print_r($_POST);
    echo '</pre>'; */
    echo $formData;

            //API URL
        $url = 'https://exc-staging-pr-5.herokuapp.com/api/v2/pluginSignup';

        // $data = array(
        //     'username' => 'tecadmin',
        //     'password' => '012345678'
        // );
         
        $payload = $formData;
         
        // Prepare new cURL resource
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
         
        // Set HTTP Header for POST request 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
        );
         
        // Submit the POST request
        $result = curl_exec($ch);
         
        if(curl_exec($ch) === false)
        {
            echo 'Curl error: ' . curl_error($ch);
        }
        else
        {
            echo 'Operation completed without any errors';
        }
        // Close cURL session handle
        curl_close($ch);
}

function ajaxcontact_enqueuescripts() {
    $params = array ( 'ajaxurl' => admin_url( 'admin-ajax.php' ) );
	wp_enqueue_script( 'ajaxcontact', plugins_url( 'assets/js/ajaxcontact.js', dirname(__FILE__) ), array( 'jquery' ), false );				
    wp_localize_script( 'ajaxcontact', 'params', $params );

    //wp_enqueue_script('ajaxcontact', plugins_url( 'assets/js/ajaxcontact.js', dirname(__FILE__) ), array('jquery'));
    //wp_localize_script( 'ajaxcontact', 'contact_form', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}
add_action('wp_enqueue_scripts', 'ajaxcontact_enqueuescripts');