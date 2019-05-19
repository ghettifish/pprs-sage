jQuery(document).ready(() => {
  //For the mobile nav menu
  // Change the Href to the # for the UL
  // Add the data toggle to "collapse" on the top level link
  // function isDesktop() {
  //   return jQuery('#desktopNavigation').css('display') === 'flex';
  // }
  var navbar = document.getElementById('desktopNavigation');

  let offset;
  offset = navbar.getBoundingClientRect();
  jQuery('.main-nav__sub-menu--0').css('top', offset.bottom);
  jQuery('.col-nav__sub-menu--0').css('top', offset.height);
  setTimeout(function () {
    console.log(offset);
    //var bottom = -navbar.height();

  }, 3000);

  function isBrowserMoreThan(width) {
    let browser = document.body.getBoundingClientRect();
    return browser.width > width;

  }


  //Dropdown for minerals
  function showMinerals(object) {

    if (isBrowserMoreThan(768)) {
      let $dropdown = jQuery(object)
        .find('.col-nav__sub-menu--0')
        .stop(true, true);
      // if($dropdown.hasClass('slideOutLeft')){
      //     $dropdown.removeClass('slideOutLeft');
      // }

      // let $column = jQuery(object)
      // .find('.col-nav__col')
      // .stop(true, true);

      // $column.addClass('animated faster slideInDown');
      $dropdown.addClass('show');
      $dropdown.one(
        'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',
        function () {
          $dropdown.removeClass('show');
        }
      );
    }
  }

  function hideMinerals(object) {
    if (isBrowserMoreThan(768)) {
      let $dropdown = jQuery(object).find('.col-nav__sub-menu--0');

      // $dropdown.addClass('animated faster slideOutUp');
      $dropdown.removeClass('show');
      $dropdown.one(
        'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',
        function () {
          $dropdown.removeClass('show');
        }
      );
    }
  }


  jQuery('.minerals').hover(
    function () {
      showMinerals(this);
    },
    function () {
      hideMinerals(this);
    }
  );

  jQuery('.main-nav__item--0').hover(
    function () {

      if (isBrowserMoreThan(768)) {
        let test = jQuery(this).find('.main-nav__sub-menu--0');
        console.log(test);
        test.addClass('main-nav__sub-menu--show');
      }
    },
    function () {

      if (isBrowserMoreThan(768)) {
        jQuery(this)
          .find('.main-nav__sub-menu--0')
          .removeClass('main-nav__sub-menu--show');
      }
    }
  );


  //Handle searching on site
  let searchVisible = false;
  jQuery('#toggleSearch').click(function () {
    searchVisible = !searchVisible;
    if (searchVisible) {
      jQuery('#searchBar').slideDown();
    } else {
      jQuery('#searchBar').slideUp();
    }
  });
});

jQuery('#openMenu').click(function () {
  jQuery('.nav-primary').addClass('mobile-menu--show');
  jQuery('#closeMenu').addClass('mobile-menu--show');
})

jQuery('#closeMenu').click(function () {
  jQuery('.nav-primary').removeClass('mobile-menu--show');
  jQuery('#closeMenu').removeClass('mobile-menu--show');
})
