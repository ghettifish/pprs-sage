@php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! $messages ) {
	return;
}
@endphp
<ul class="woocommerce-error pprs-error" id="pprs-error" role="alert">
	@foreach($messages as $message)
		<li>
			{!! wc_kses_notice( $message ) !!}
		</li>
	@endforeach
</ul>
