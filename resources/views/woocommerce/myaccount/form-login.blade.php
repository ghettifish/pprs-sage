{{--
 The View for the WooCommerce Login screen
--}}


@php 
	wc_print_notices();
	do_action( 'woocommerce_before_customer_login_form' );
@endphp
<div class="row justify-content-center login-form align-items-center">
	<div class="col-xs-12 col-md-4 align-self-center" id="login">
			<h2>{{ _e( 'Login', 'understrap' )}}</h2>
			<form class="woocommerce-form woocommerce-form-login login-form__form" method="post">

				{{ do_action( 'woocommerce_login_form_start' )}}

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="username">{{_e( 'Username or email address', 'understrap' )}}<span class="required">*</span></label>
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" value="{!!( ! empty( $_POST['username'] ) ) ? esc_attr( $_POST['username'] ) : ''!!}" />
				</p>
				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="password">{{_e( 'Password', 'understrap' )}}<span class="required">*</span></label>
					<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" />
				</p>

				{{ do_action( 'woocommerce_login_form' )}}

				<p class="form-row">
					{!! wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ) !!}
					<input type="submit" class="login-form__btn" name="login" value="{{esc_attr_e( 'Login', 'understrap' )}}" />
					<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline login-form__checkbox">
						<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span>{{ _e( 'Remember me', 'understrap' )}}</span>
					</label>
					<p class="woocommerce-LostPassword lost_password">
						<a href="{{esc_url( wp_lostpassword_url() )}}">{{_e( 'Lost your password?', 'understrap' )}}</a>
					</p>
				</p>
			

				{{do_action( 'woocommerce_login_form_end' )}}

			</form>
			<p class="login-form__register">Don't have an account yet? <a href="#register-form" id="toggleToRegister">{{_e('Register for an account')}}</a></p>

	</div>
	@if( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' )

	<div class="col-xs-10 col-md-6 registration" id="register">
			<h2>{{_e( 'Register', 'understrap' )}}</h2>
			<a href="#" id="toggleToLogin">Login instead</a>


			<form method="post" class="register ">
					{{-- {{do_action( 'woocommerce_register_form_start' )}} --}}
					<h3><?php _e( 'Personal Info', 'woocommerce' ); ?></h3>	
					{{do_action( 'woocommerce_login_form_start' )}}

					{{do_action( 'woocommerce_register_form_personal' )}}
					{{do_action( 'woocommerce_register_form_billing' )}}

					<h3>Account Info</h3>
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="reg_username">{{_e( 'Username', 'understrap' )}}<span class="required">*</span></label>
						<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" value="{!! ( ! empty( $_POST['username'] ) ) ? esc_attr( $_POST['username'] ) : ''!!}" />
					</p>
	
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="reg_email">{{_e( 'Email address', 'understrap' )}}<span class="required">*</span></label>
						<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" value="{{( ! empty( $_POST['email'] ) ) ? esc_attr( $_POST['email'] ) : ''}}" />
					</p>
					@if( 'no' === get_option( 'woocommerce_registration_generate_password' ) )

					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="reg_password">{{_e( 'Password', 'understrap' )}}<span class="required">*</span></label>
						<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" />
					</p>
					@endif

				{{ do_action( 'woocommerce_register_form' )}}

				<p class="woocommerce-FormRow form-row">
					{!! wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' )!!}
					<input type="submit" class="login-form__btn" name="register" value="{{esc_attr_e( 'Register', 'understrap' )}}" />
				</p>

				{{ do_action( 'woocommerce_register_form_end' )}}

			</form>

	</div>


	</div>

	@endif
	</div>
</div>
{{ do_action( 'woocommerce_after_customer_login_form' )}}

			
	
