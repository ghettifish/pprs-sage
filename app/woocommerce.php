<?php
/**
 * Add WooCommerce support
 *
 * @package understrap
 */

//In case you want to nuke all woocommerce styles
//add_filter( 'woocommerce_enqueue_styles', '__return_false' );

function addDiv($thing) {
	echo "<div>" . $thing . "</div>";
}

 function testWoo($thing) {
	 echo $thing;?>
 <?php }

add_filter('woocommerce_account_navigation', 'testWoo');

add_action( 'after_setup_theme', 'understrap_woocommerce_support' );
if ( ! function_exists( 'understrap_woocommerce_support' ) ) {
	/**
	 * Declares WooCommerce theme support.
	 */
	function understrap_woocommerce_support() {
		add_theme_support( 'woocommerce' );

		// Add New Woocommerce 3.0.0 Product Gallery support
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-slider' );

		// hook in and customizer form fields.
		add_filter( 'woocommerce_form_field_args', 'understrap_wc_form_field_args', 10, 3 );
	}
}

/*Get rid of tabs*/
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {

unset( $tabs['description'] ); // Remove the description tab
unset( $tabs['reviews'] ); // Remove the reviews tab
unset( $tabs['additional_information'] ); // Remove the additional information tab

return $tabs;

}
/**
 * Filter hook function monkey patching form classes
 * Author: Adriano Monecchi http://stackoverflow.com/a/36724593/307826
 *
 * @param string $args Form attributes.
 * @param string $key Not in use.
 * @param null   $value Not in use.
 *
 * @return mixed
 */
function understrap_wc_form_field_args( $args, $key, $value = null ) {
	// Start field type switch case.
	switch ( $args['type'] ) {
		/* Targets all select input type elements, except the country and state select input types */
		case 'select' :
			// Add a class to the field's html element wrapper - woocommerce
			// input types (fields) are often wrapped within a <p></p> tag.
			$args['class'][] = 'form-group';
			// Add a class to the form input itself.
			$args['input_class']       = array( 'form-control', 'input-lg' );
			$args['label_class']       = array( 'control-label' );
			$args['custom_attributes'] = array(
				'data-plugin'      => 'select2',
				'data-allow-clear' => 'true',
				'aria-hidden'      => 'true',
				// Add custom data attributes to the form input itself.
			);
			break;
		// By default WooCommerce will populate a select with the country names - $args
		// defined for this specific input type targets only the country select element.
		case 'country' :
			$args['class'][]     = 'form-group single-country';
			$args['label_class'] = array( 'control-label' );
			break;
		// By default WooCommerce will populate a select with state names - $args defined
		// for this specific input type targets only the country select element.
		case 'state' :
			// Add class to the field's html element wrapper.
			$args['class'][] = 'form-group';
			// add class to the form input itself.
			$args['input_class']       = array( '', 'input-lg' );
			$args['label_class']       = array( 'control-label' );
			$args['custom_attributes'] = array(
				'data-plugin'      => 'select2',
				'data-allow-clear' => 'true',
				'aria-hidden'      => 'true',
			);
			break;
		case 'password' :
		case 'text' :
		case 'email' :
		case 'tel' :
		case 'number' :
			$args['class'][]     = 'form-group';
			$args['input_class'] = array( 'form-control', 'input-lg' );
			$args['label_class'] = array( 'control-label' );
			break;
		case 'textarea' :
			$args['input_class'] = array( 'form-control', 'input-lg' );
			$args['label_class'] = array( 'control-label' );
			break;
		case 'checkbox' :
			$args['label_class'] = array( 'custom-control custom-checkbox' );
			$args['input_class'] = array( 'custom-control-input', 'input-lg' );
			break;
		case 'radio' :
			$args['label_class'] = array( 'custom-control custom-radio' );
			$args['input_class'] = array( 'custom-control-input', 'input-lg' );
			break;
		default :
			$args['class'][]     = 'form-group';
			$args['input_class'] = array( 'form-control', 'input-lg' );
			$args['label_class'] = array( 'control-label' );
			break;
	} // end switch ($args).
	return $args;
}

//Don't display title on sidebar widget for archive pages

add_filter('widget_title','hide_title');
function hide_title($t)
{
    return null;
}



add_action( 'woocommerce_thankyou', 'custom_woocommerce_auto_complete_order' );
function custom_woocommerce_auto_complete_order( $order_id ) {
    if ( ! $order_id ) {
        return;
    }

    $order = wc_get_order( $order_id );
    $order->update_status( 'on-hold' );
}



 function wooc_extra_register_fields() {?>
 <p class="form-row form-row-wide">
	<label for="reg_billing_phone"><?php _e( 'Company Name', 'woocommerce' ); ?></label>
	<input type="text" class="input-text" name="company_name" id="reg_company_name" value="<?php esc_attr_e( $_POST['company_name'] ); ?>" />
</p>
<p class="form-row form-row-first">
	<label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?><span class="required">*</span></label>
	<input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
</p>
<p class="form-row form-row-last">
	<label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?><span class="required">*</span></label>
	<input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
</p>
<div class="clear"></div>
<?php
}

// add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );


function login() {
	$login_text = __('You can not add items to your cart unless you have an account and are signed in.');
	$link_text = __('Login to purchase.', 'woocommerce');
	$open_link = ' <a href="' . get_permalink( wc_get_page_id( 'myaccount' )) . '">';
	$close_link = '</a>';

	$html = $login_text . $open_link . $link_text. $close_link;
	echo $html;
}

// Hide add to cart button for users who're not logged in
function remove_add_to_cart() {
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
	add_filter( 'woocommerce_single_product_summary', 'login');
}

if(!is_user_logged_in()) remove_add_to_cart();


function get_breadcrumbs() {
    try {
        $args = array(
            'posts_per_page' => -1,
            'tax_query' => $tax_array,
            'post_type' => 'product',
            'orderby' => 'title',
        );

        $catIdForBackground = get_term_by('slug', $last, 'product_cat')->term_id;

        // get the thumbnail id using the queried category term_id
        $thumbnail_id = get_woocommerce_term_meta( $catIdForBackground, 'thumbnail_id', true );

        // get the image URL
        $image = wp_get_attachment_url( $thumbnail_id );

        $hasImage = 'style="background: url(' . $image . ') no-repeat center center fixed;"';

        $background = $image ? $hasImage : "";

        include(locate_template('./loop-templates/content-cat-header.php'));

	}

	catch(\Exception $e) {
		include( get_query_template( '404' ) );
		return;
	}
}


function buildArgs() {
    global $wp_query;

    $pprscat = urldecode($wp_query->query['product_cat']);
    $pprscats = explode("/", $pprscat);
    $tax_array = array(
        'relation' => 'AND'
    );
    foreach($pprscats as $cat) {
        array_push($tax_array, array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => $cat
        ));
    }
    unset($cat);
    $args = array(
        'posts_per_page' => -1,
        'tax_query' => $tax_array,
        'post_type' => 'product',
        'orderby' => 'title',
    );
    $the_query = new WP_Query( $args);
    $products = [];
    foreach($the_query->posts as $post) {
        $current = wc_get_product( $post->ID );
        if($current->is_visible() && $current->is_in_stock()) {
            array_push($products, $current);
        }
    }
return $products;
}


add_action('get_category_breadcrumb', function() {
    global $wp_query;
    $args =  $wp_query->query;
    try {
		if(isset($wp_query->query['product_cat'])) {
			$pprscat = urldecode($wp_query->query['product_cat']);
			$pprscats = explode("/", $pprscat);
			$tax_array = array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => 'exclude-from-catalog',
					'operator' => 'NOT IN',
				)
			);


			$last = $pprscats[count($pprscats) - 1];
			$title = get_term_by('slug', $last, 'product_cat')->name;
			$breadcrumb = "";
			$cateogries = end($pprscats);
			foreach($pprscats as $cat) {
				array_push($tax_array, array(
					'taxonomy' => 'product_cat',
					'field' => 'slug',
					'terms' => $cat
				));
				$term = get_term_by('slug', $cat, 'product_cat');
					if(!$term) throw new Exception('No category available');
				$id = $term->term_id;
				$name = $term->name;
				$category_link = get_term_link($id);
				if($cat != $last) {
					$breadcrumb .= '<a href="' . $category_link . '">' . $name . "</a> / ";
				} else {
					$breadcrumb .= $name;
				}
            }
            echo $breadcrumb;
			unset($cat);
		}
    }
    catch(\Exception $e) {
		include( get_query_template( '404' ) );
		return;
	}
});

