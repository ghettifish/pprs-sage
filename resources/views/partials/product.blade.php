<div  class="col-md-4 col-sm-6 text-center"> 
  <div class="pprs-product">
    <a href="{!!$product->get_permalink()!!}">
        <div class="pprs-product__image"
        style="background-image: url({!!get_the_post_thumbnail_url($product->get_id())!!})">
        </div>
    </a>
    <a href="{!!$product->get_permalink()!!}">
          <div class="pprs-product__details">
              <h4 class="pprs-product__title">{!!$product->get_title()!!}</h4>
              <p class="pprs-product__price">{!!$product->get_price_html()!!}</p>
            </div>
    </a>
  </div>
</div>
