jQuery(document).ready(() => {
  //For the mobile nav menu
  // Change the Href to the # for the UL
  // Add the data toggle to "collapse" on the top level link
    // function isDesktop() {
    //   return jQuery('#desktopNavigation').css('display') === 'flex';
    // }
  var navbar = document.getElementById('desktopNavigation');

  let offset;
  setTimeout( function() {
    offset = navbar.getBoundingClientRect();
      //var bottom = -navbar.height();
    jQuery('.main-nav__sub-menu--0').css('top', offset.bottom);
    jQuery('.col-nav__sub-menu--0').css('top', offset.bottom);
  }, 3000);
  


  //Dropdown for minerals
  function showMinerals(object) {
    let $dropdown = jQuery(object)
      .find('.col-nav__sub-menu--0')
      .stop(true, true);
    // if($dropdown.hasClass('slideOutLeft')){
    //     $dropdown.removeClass('slideOutLeft');
    // }

    $dropdown.addClass('animated fast slideInLeft show');

    $dropdown.one(
      'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',
      function() {
        $dropdown.removeClass('slideInLeft');
      }
    );
  }

  function hideMinerals(object) {
    let $dropdown = jQuery(object).find('.col-nav__sub-menu--0');

    $dropdown.addClass('animated faster slideOutLeft');
    $dropdown.one(
      'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',
      function() {
        $dropdown.removeClass('slideOutLeft');
        $dropdown.removeClass('show');
      }
    );
  }
  jQuery('.minerals').hover(
    function() {
      showMinerals(this);
    },
    function() {
      hideMinerals(this);
    }
  );

  jQuery('.main-nav__item--0').hover(
    function() {
      let test = jQuery(this).find('.main-nav__sub-menu--0');
      console.log(test);
      test.addClass('main-nav__sub-menu--show');
    },
    function() {
      jQuery(this)
        .find('.main-nav__sub-menu--0')
        .removeClass('main-nav__sub-menu--show');
    }
  );

  //Handle searching on site
  let searchVisible = false;
  jQuery('#toggleSearch').click(function() {
    searchVisible = !searchVisible;
    if (searchVisible) {
      jQuery('#searchBar').slideDown();
    } else {
      jQuery('#searchBar').slideUp();
    }
  });
});
