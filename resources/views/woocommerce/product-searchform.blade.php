@php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
@endphp
<form role="search" method="get" class="woocommerce-product-search pprs-search" action="{{esc_url( home_url( '/' ) )}}">

  <label class="screen-reader-text" for="woocommerce-product-search-field-{{isset( $index ) ? absint( $index ) : 0}}">
    {{esc_html_e( 'Search for:', 'woocommerce' )}}
  </label>

  <button 
    type="submit"
    class="pprs-search__btn"
    value="{{esc_attr_x( 'Search', 'submit button', 'woocommerce' )}}"
    aria-label="search"
  >
  <i class="fas fa-search"></i>
  </button>

  <input 
    type="search" 
    id="woocommerce-product-search-field-{{isset( $index ) ? absint( $index ) : 0}}" 
    class="search-field pprs-search__field" 
    placeholder="{!!esc_attr__( 'Search products&hellip;', 'woocommerce' )!!}" 
    value="{{get_search_query()}}" 
    name="s" 
  />



  <input type="hidden" name="post_type" value="product" />
  
</form>
