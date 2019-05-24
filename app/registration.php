<?php
if (!defined('ABSPATH')) exit;



/**
 * Add custom fields
 */

function pprc_get_account_fields() {
	return apply_filters( 'pprc_account_fields', array(
		'fein' => array(
			'type'        => 'text',
			'label'       => __( 'Fein', 'pprc' ),
			'required'    => true,
			'class'       => array('form-row-last'),
		),
		'rep' => array(
			'type'        => 'text',
			'label'       => __( 'Rep', 'pprs' ),
			'required'    => false,
			'class'       => array('form-row-last'),
		),
	) );
}
function pprc_print_user_frontend_fields() {
	$fields = pprc_get_account_fields();
	foreach ( $fields as $key => $field_args ) {
		woocommerce_form_field( $key, $field_args );
	}
}

add_action( 'woocommerce_edit_account_form', 'pprc_print_user_frontend_fields', 10 );

function pprc_checkout_fields( $checkout_fields ) {
	$fields = pprc_get_account_fields();

	foreach ( $fields as $key => $field_args ) {
		$field_args['class'][0] = 'form-row-wide';
		$checkout_fields['billing'][ $key ] = $field_args;
	}

	return $checkout_fields;
}

// add_filter( 'woocommerce_checkout_fields', 'pprc_checkout_fields', 10, 1 );



/**
 * Add fields to admin area.
 *
 * @see https://pprcwp.com/blog/the-ultimate-guide-to-adding-custom-woocommerce-user-account-fields/
 */
function pprc_print_user_admin_fields( $profileuser ) {
	$fields = pprc_get_account_fields();

	if(empty($fein)){
		$fein = '';
	}
	?>
	<h2><?php _e( 'Additional Information', 'pprc' ); ?></h2>
	<table class="form-table" id="pprc-additional-information">
		<tbody>
		<?php foreach ( $fields as $key => $field_args ) { ?>
			<tr>
				<th>
					<label for="<?php echo $key; ?>"><?php echo $field_args['label']; ?></label>
				</th>
				<td>
					<?php $field_args['label'] = false; ?>
					<?php woocommerce_form_field( $key, $field_args,get_the_author_meta( $key, $profileuser->ID ) ); ?>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<?php
}

add_action( 'show_user_profile', 'pprc_print_user_admin_fields', 30 ); // admin: edit profile
add_action( 'edit_user_profile', 'pprc_print_user_admin_fields', 30 ); // admin: edit other users

/**
 * Save registration fields.
 *
 * @param int $customer_id
 *
 */
function pprc_save_account_fields( $customer_id ) {
	$fields = pprc_get_account_fields();

	foreach ( $fields as $key => $field_args ) {
		$sanitize = isset( $field_args['sanitize'] ) ? $field_args['sanitize'] : 'wc_clean';
		$value    = isset( $_POST[ $key ] ) ? call_user_func( $sanitize, $_POST[ $key ] ) : '';
		update_user_meta( $customer_id, $key, $value );
	}
}

add_action( 'woocommerce_created_customer', 'pprc_save_account_fields' ); // register/checkout
add_action( 'personal_options_update', 'pprc_save_account_fields' ); // edit own account admin
add_action( 'edit_user_profile_update', 'pprc_save_account_fields' ); // edit other account admin
add_action( 'woocommerce_save_account_details', 'pprc_save_account_fields' ); // edit WC account

/*prevent any orders from autocompleting*/
/*
 */
add_action( 'woocommerce_thankyou', 'stop_auto_complete_order' );
function stop_auto_complete_order( $order_id ) { 
    if ( ! $order_id ) {
        return;
    }

    $order = wc_get_order( $order_id );
    $order->update_status( 'processing' );
}

if(!is_admin())
{


function pprs_register_personal_info() {
	global $woocommerce;
	$checkout = $woocommerce->checkout();
	$woocommerce->checkout()->enqueue_scripts;
	$count = 1;
	foreach ($checkout->checkout_fields['billing'] as $key => $field) :
		if( $count<4 ) {
			woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
		}
		$count ++;
	endforeach;

	$args = array(
    "label"             => "Phone",
    "required"          => true,
    "type"              => "tel",
    "class"             => array("form-row-first"),
    "validate"          => array(
    "0"                 => "phone"
		),
		"autocomplete"   => "tel",
		"priority"       => 100,
	);
	woocommerce_form_field( 'billing_phone', $args, $checkout->get_value( 'billing_phone' ) );
	$fields = pprc_get_account_fields();
	foreach ( $fields as $key => $field_args ) {
		woocommerce_form_field( $key, $field_args );    
	}
}
add_action( 'woocommerce_register_form_personal', 'pprs_register_personal_info' );

function pprs_register_billing_info() {
	global $woocommerce;
	$checkout = $woocommerce->checkout();?>

	<!-- <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" />
	</p> -->

	<h3 class="registration__form-title"><?php _e( 'Billing Address', 'woocommerce' ); ?></h3>
	<?php
	foreach ($checkout->checkout_fields['billing'] as $key => $field) :

		if($key === 'billing_address_1' 
		|| $key === 'billing_address_2' 
		|| $key === 'billing_state' 
		|| $key === 'billing_city' 
		|| $key === 'billing_country' 
		|| $key === 'billing_postcode') {
			woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
		}
		
	endforeach;
	?>

	<div class="shipping_address">
		<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
			<input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" /> <span><?php _e( 'Ship to a different address?', 'woocommerce' ); ?></span>
		</label>

		<div class="registration__shipping-address" id="shippingAddress">
			<h3 class="registration__form-title">
				<?php _e( 'Shipping Address', 'woocommerce' ); ?>
			</h3>

			<?php
			foreach ($checkout->checkout_fields['shipping'] as $key => $field) :
				if ( isset( $field['country_field'], $checkout->checkout_fields['shipping'][ $field['country_field'] ] ) ) {
					$field['country'] = $checkout->get_value( $field['country_field'] );
				}
				woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
			endforeach;
			?>
		</div>
	</div>
		<?php

}



add_action( 'woocommerce_register_form_billing', 'pprs_register_billing_info' );

// Custom function to save Usermeta or Billing Address of registered user
function pprs_save_address($user_id)
{
	global $woocommerce;
	$address = $_POST;
	foreach ($address as $key => $field) :
		if( $key == 'billing_first_name' || $key == 'billing_last_name')
		{
			$new_key = explode('billing_',$key);
			update_user_meta( $user_id, $new_key[1], $_POST[$key] );
		}
		if(strpos($key, 'billing_') !== false) {
			update_user_meta( $user_id, $key, $_POST[$key] );
		}
		if(strpos($key, 'shipping_') !== false) {
			if( empty($_POST['ship_to_different_address']) ){
				$key_parts = explode('_', $key,2 );
				$shipping_key = 'billing_'.end($key_parts);
				if( 'billing' === $key_parts[0] ){
					update_user_meta( $user_id, $key, $_POST[$key] );
				}elseif('shipping' === $key_parts[0]){
					update_user_meta( $user_id, $key, $_POST[$shipping_key] );
				}
			} else {
				update_user_meta( $user_id, $key, $_POST[$key] );
			}
		}
	endforeach;

}
add_action('woocommerce_created_customer','pprs_save_address');

	/**

	 * Validate the extra register fields.

	 *

	 * @param string $username         Current username.

	 * @param string $email             Current email.

	 * @param object $validation_errorsWP_Error object.

	 *

	 * @return void

	 */
	function pprs_validate_extra_register_fields( $username, $email, $validation_errors ) {

		if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
			$validation_errors->add( 'billing_first_name_error', __( 'First name is required!', 'woocommerce' ) );
		}

		if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
			$validation_errors->add( 'billing_last_name_error', __( 'Last name is required!.', 'woocommerce' ) );
		}

		if ( isset( $_POST['fein'] ) && empty( $_POST['fein'] ) ) {
			$validation_errors->add( 'fein_error', __( 'FEIN is required!', 'woocommerce' ) );
		}

		if ( isset( $_POST['billing_country'] ) && empty( $_POST['billing_country'] ) ) {
			$validation_errors->add( 'billing_country_error', __( 'Select the country!', 'woocommerce' ) );
		}

		if ( isset( $_POST['billing_address_1'] ) && empty( $_POST['billing_address_1'] ) ) {
			$validation_errors->add( 'billing_address_1_error', __( 'Street address is required!', 'woocommerce' ) );
		}

		if ( isset( $_POST['billing_state'] ) && empty( $_POST['billing_state'] ) ) {
			$validation_errors->add( 'billing_state_error', __( 'State / County is required!', 'woocommerce' ) );
		}

		if ( isset( $_POST['billing_postcode'] ) && empty( $_POST['billing_postcode'] ) ) {
			$validation_errors->add( 'billing_postcode_error', __( 'Postcode / ZIP is required!.', 'woocommerce' ) );
		}
		if( !empty($_POST['ship_to_different_address']) ){
			if ( isset( $_POST['shipping_first_name'] ) && empty( $_POST['shipping_first_name'] ) ) {
				$validation_errors->add( 'shipping_first_name_error', __( 'Shipping First name is required!', 'woocommerce' ) );
			}

			if ( isset( $_POST['shipping_last_name'] ) && empty( $_POST['shipping_last_name'] ) ) {
				$validation_errors->add( 'shipping_last_name_error', __( 'Shipping Last name is required!.', 'woocommerce' ) );
			}

			if ( isset( $_POST['shipping_country'] ) && empty( $_POST['shipping_country'] ) ) {
				$validation_errors->add( 'shipping_country_error', __( 'Select the Shipping country!', 'woocommerce' ) );
			}

			if ( isset( $_POST['shipping_city'] ) && empty( $_POST['shipping_city'] ) ) {
				$validation_errors->add( 'sshipping_city_error', __( 'Shipping Town / City is required!', 'woocommerce' ) );
			}

			if ( isset( $_POST['shipping_address_1'] ) && empty( $_POST['shipping_address_1'] ) ) {
				$validation_errors->add( 'shipping_address_1_error', __( 'Shipping Street address is required!', 'woocommerce' ) );
			}

			if ( isset( $_POST['shipping_state'] ) && empty( $_POST['shipping_state'] ) ) {
				$validation_errors->add( 'shipping_state_error', __( 'Shipping State / County is required!', 'woocommerce' ) );
			}

			if ( isset( $_POST['shipping_postcode'] ) && empty( $_POST['shipping_postcode'] ) ) {
				$validation_errors->add( 'shipping_postcode_error', __( 'Shipping Postcode / ZIP is required!.', 'woocommerce' ) );
			}
        }

	}



	add_action( 'woocommerce_register_post', 'pprs_validate_extra_register_fields', 10, 3 );
}

function pprs_new_user_approve_autologout(){
	if ( is_user_logged_in() ) {
		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;

		if ( get_user_meta($user_id, 'pw_user_status', true )  === 'approved' ){ $approved = true; }
		else{ $approved = false; }


		if ( $approved ){
			return $redirect_url;
		}
		else{
			wp_logout();
			return home_url('/thanks-for-registering/');
			//return add_query_arg( 'approved', 'false', get_permalink( get_option('woocommerce_myaccount_page_id') ) );
		}
	}
}
add_action('woocommerce_registration_redirect', 'pprs_new_user_approve_autologout', 2);

function pprs_new_user_approve_registration_message(){
	$not_approved_message = '<p class="registration">Send in your registration application today!<br /> NOTE: Your account will be held for moderation and you will be unable to login until it is approved.</p>';

	if( isset($_REQUEST['approved']) ){
		$approved = $_REQUEST['approved'];
		if ($approved == 'false')  echo '<p class="registration successful">Registration successful! You will be notified upon approval of your account.</p>';
		else echo $not_approved_message;
	}
	else echo $not_approved_message;
}
add_action('woocommerce_before_customer_login_form', 'pprs_new_user_approve_registration_message', 2);

function pprs_new_user_approve_send_approved_email($user_id){

	global $woocommerce;
	//Instantiate mailer
	$mailer = $woocommerce->mailer();

	if (!$user_id) return;

	$user = new WP_User($user_id);

	$user_login = stripslashes($user->user_login);
	$user_email = stripslashes($user->user_email);
	$user_pass  = "As specified during registration";

	$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

	$subject  = apply_filters( 'woocommerce_email_subject_customer_new_account', sprintf( __( 'Your account on %s has been approved!', 'woocommerce'), $blogname ), $user );
	$email_heading  = "User $user_login has been approved";

	// Buffer
	ob_start();

	// Get mail template
	wc_get_template('emails/customer-account-approved.php', array(
		'user_login'    => $user_login,
		'user_pass'             => $user_pass,
		'blogname'              => $blogname,
		'email_heading' => $email_heading
	));

	// Get contents
	$message = ob_get_clean();

	// Send the mail
	wc_mail( $user_email, $subject, $message, $headers = "Content-Type: text/htmlrn", $attachments = "" );

	$customer_orders = wc_get_orders( array(
		'meta_key' => '_customer_user',
		'meta_value' => $user_id,
		'post_status' => array('faild'),
		'numberposts' => -1
	) );
	if( !empty( $customer_orders ) ){
		foreach( $customer_orders as $order ){
			if( 'failed' === $order->get_status() ){
				$order->update_status( 'on-hold' );
			}
		}
    }

}
add_action('new_user_approve_approve_user', 'pprs_new_user_approve_send_approved_email', 10, 1);

function pprs_new_user_approve_send_denied_email($user_id){
	return;
}
add_action('new_user_approve_deny_user', 'pprs_new_user_approve_send_denied_email', 10, 1);

add_action( 'woocommerce_thankyou', 'pprs_process_order');

function pprs_process_order( $order_id ){
	$order = new WC_Order( $order_id );
	if ( !empty( $order->get_user_id() ) && get_user_meta($order->get_user_id(), 'pw_user_status', true )  !== 'approved' ) {
		$order->update_status( 'failed' );
		wp_logout();
		wp_redirect(get_permalink( get_option('woocommerce_myaccount_page_id')));
		return add_query_arg( 'approved', 'false', get_permalink( get_option('woocommerce_myaccount_page_id') ) );
		exit;
	}

}