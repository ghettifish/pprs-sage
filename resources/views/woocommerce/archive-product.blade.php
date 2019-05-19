{{--
The Template for displaying product archives, including the main shop page which is a post type archive
This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
HOWEVER, on occasion WooCommerce will need to update template files and you
(the theme developer) will need to copy the new files to your theme to
maintain compatibility. We try to do this as little as possible, but it does
happen. When this occurs the version of the template file will be bumped and
the readme will list any important changes.
@see https://docs.woocommerce.com/document/template-structure/
@package WooCommerce/Templates
@version 3.4.0
--}}

@extends('layouts.app')

@section('content')
<div class="archive-product">
  @php
    $tax_array = buildArgs();
  @endphp

  <header class="container archive-product__header  text-center" style="{!!
    get_archive_header()
    !!}">
    <div class="archive-product__text-wrapper">
      <div class="col-12">
        @if(apply_filters('woocommerce_show_page_title', true))
          <h1 class="archive-product__title">{!! woocommerce_page_title(false) !!}</h1>
        @endif
      </div>
      <div class="col-12">
        {!!do_action('get_category_breadcrumb');!!}
      </div>
    </div>

    @php
      do_action('woocommerce_archive_description');
    @endphp
  </header>
  <div class="container">
    <div class="row">
        @if($tax_array)
          @foreach($tax_array as $product)
            @include('partials.product', ['product'=>$product])
          @endforeach
        @else
          <p>No products available</p>
        @endif
    </div>
  </div>

  {{-- @if(woocommerce_product_loop())
    @php
      do_action('woocommerce_before_shop_loop');
      woocommerce_product_loop_start();
    @endphp

    @if(wc_get_loop_prop('total'))
      @while(have_posts())
        @php
          the_post();
          do_action('woocommerce_shop_loop');
          wc_get_template_part('content', 'product');
        @endphp
      @endwhile
    @endif

    @php
      woocommerce_product_loop_end();
      do_action('woocommerce_after_shop_loop');
    @endphp
  @else
    @php
      do_action('woocommerce_no_products_found');
    @endphp
  @endif --}}

  @php
    do_action('woocommerce_after_main_content');
    do_action('get_sidebar', 'shop');
    do_action('get_footer', 'shop');
  @endphp
</div>
@endsection
