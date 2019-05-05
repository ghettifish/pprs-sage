export default {
  init() {
    // JavaScript to be fired on the home page
    jQuery('#pprs-slider').slick({
      'slidesToShow': 1,
      'arrows': false,
      'autoplay': true,
      'dots': true,
    });
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  },
};
