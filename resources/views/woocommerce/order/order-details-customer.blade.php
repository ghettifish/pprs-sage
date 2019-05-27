@php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$show_shipping = ! wc_ship_to_billing_address_only() && $order->needs_shipping_address();
@endphp

<section class="woocommerce-customer-details">

	@if($show_shipping)
	<section class="woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses col2-set addresses row">
		<div class="woocommerce-column woocommerce-column--1 woocommerce-column--billing-address col-6">
	@endif

	<h2 class="woocommerce-column__title">{{esc_html_e( 'Billing address', 'woocommerce' )}}</h2>
	<address>
		{!! wp_kses_post( $order->get_formatted_billing_address( __( 'N/A', 'woocommerce' ) ) ) !!}

		@if($order->get_billing_phone())
			<p class="woocommerce-customer-details--phone">{{esc_html( $order->get_billing_phone() )}}</p>
		@endif

		@if($order->get_billing_email())
			<p class="woocommerce-customer-details--email">{{$order->get_billing_email()}}</p>
		@endif
	</address>

	@if($show_shipping)
		</div><!-- /.col-1 -->
		<div class="woocommerce-column woocommerce-column--2 woocommerce-column--shipping-address col-6">
			<h2 class="woocommerce-column__title">{{esc_html_e( 'Shipping address', 'woocommerce' )}}</h2>
			<address>
				{!! wp_kses_post($order->get_formatted_shipping_address(__( 'N/A', 'woocommerce' )))!!}
			</address>
		</div><!-- /.col-2 -->

	</section><!-- /.col2-set -->
	@endif

	{{do_action( 'woocommerce_order_details_after_customer_details', $order )}}

</section>
