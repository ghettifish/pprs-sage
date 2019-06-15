@php
defined( 'ABSPATH' ) || exit;

global $product;
// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
@endphp

<div  class="col-md-5 col-sm-6 text-center"> 
  <div class="pprs-product--flat">
    <a href="{!!$product->get_permalink()!!}">
        <div class="pprs-product__image"
        style="background-image: url({!!get_the_post_thumbnail_url($product->get_id())!!})">
        </div>
    </a>
    <a href="{!!$product->get_permalink()!!}">
          <div class="pprs-product__details--bottom">
              <h4 class="pprs-product__title">{!!$product->get_title()!!}</h4>
              <p class="pprs-product__price">{!!$product->get_price_html()!!}</p>
            </div>
    </a>
  </div>
</div>