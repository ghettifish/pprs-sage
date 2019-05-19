export default {
  init() {
    // JavaScript to be fired on all pages
    jQuery(document).ready(function() {
      jQuery( '#shippingAddress' ).hide();
      var ship_to_different_address = jQuery('#ship-to-different-address-checkbox');
      ship_to_different_address.change(function(){
          if ( jQuery( this ).is( ':checked' ) ) {
              jQuery( '#shippingAddress' ).slideDown();
          } else {
              jQuery( '#shippingAddress' ).slideUp();
          }
      });
  });
  
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
