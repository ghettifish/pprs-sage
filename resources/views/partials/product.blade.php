<div  class="col-md-3 col-sm-4 text-center">
  <a href="{!!$product->get_permalink()!!}">
      <div class="pprs-product__image-wrapper">
        </div>
        <div class="pprs-product__details">
            <h4 class="pprs-product__title">{!!$product->get_title()!!}</h4>
            <p class="pprs-product__price">{!!$product->get_price_html()!!}</p>
          </div>
  </a>
</div>
