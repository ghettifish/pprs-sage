export default {
    init() {
      jQuery('#toggleToRegister').click(function(){
        document.getElementById('register').style.display = 'block';
        document.getElementById('login').style.display = 'none';
      });
      jQuery('#toggleToLogin').click(function(){
        document.getElementById('login').style.display = 'block';
        document.getElementById('register').style.display = 'none';
      });
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
  