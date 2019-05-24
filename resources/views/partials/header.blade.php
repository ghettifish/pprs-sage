@php 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function cart_count() {
	$cartcount = WC()->cart->get_cart_contents_count();
	if(isset($cartcount) && $cartcount > 0) { return $cartcount; };
}

// Filter wp_nav_menu() to add additional links and other output
function nav_actions($items) {
	$li = '<li class="main-nav__item--0">';
	$a = '<a class="header__cart" href="';
	$close_a = '">';
	$close_li='</li>';
    $view_cart = $li . $a . wc_get_page_permalink('cart') . $close_a . __('Cart | ') . '<i class="fas fa-shopping-cart"></i> '. cart_count() . '</a>';
	$login = $li . $a . wc_get_page_permalink('myaccount') . $close_a . __('Login/Register ') . '<i class="fas fa-user"></i></a>';
	$search = $li . '<a  href="#" class="main-nav__link--0">Search <i class="fas fa-search header__search-icon" id="toggleSearch"></i></a>' . $close_li;
	$action = is_user_logged_in() ? $view_cart : $login ;
    $items = $items . $search;
    return $items;
}
add_filter( 'wp_nav_menu_items', 'nav_actions' );

@endphp

<header class="container-fluid main-nav__container" id="banner">
  <div class="row">
    <div class="col-xs-6 col-sm-6 col-md-3  text-left d-flex align-items-center">
      @if(has_custom_logo()) 
        {!! the_custom_logo(); !!}
      @endif
    </div>
    <div class="col-md-9 col-sm-6 text-right d-flex align-items-center">
      <div class="col-md-12">
        <ul class="secondary-nav secondary-nav--hide" >
          @if(is_user_logged_in()) 
          <li class="secondary-nav__text">
            <a href="{!!wc_get_page_permalink('cart')!!}">Cart | <i class="fas fa-shopping-cart"></i>{!!cart_count()!!}</a>
          </li>
          <li class="secondary-nav__text">
              <a href="{!!wc_get_page_permalink('myaccount')!!}">My Account</a>
          </li>
          <li class="secondary-nav__text">
              <a href="{!!wp_logout_url( wc_get_page_permalink('myaccount') );!!}">Logout</a>
          </li>
          @else
          <li class="secondary-nav__text">
            <a href="{!!wc_get_page_permalink('myaccount')!!}">Login/Register <i class="fas fa-user"></i></a>
          </li>
          @endif
        </ul>
        <li class="secondary-nav__text"><button class="secondary-nav__menu" id="openMenu">Menu</button>

        <button class="secondary-nav__close" id="closeMenu">
            Close
          </button>
      </div>
    </div>
    <div class="col-md-12 justify-content-center">
      <nav class="nav-primary main-nav__wrapper">
        @if (has_nav_menu('primary'))
          {!! wp_nav_menu(
            array(
              'theme_location'  => 'primary',
              'container_class' => '',
              'container_id'    => 'desktopNavigation',
              'menu_class'      => 'main-nav--desktop',
              'fallback_cb'     => '',
              'menu_id'         => 'desktopNav',
              'walker'          => new PPRS_Walker(),
              // 'walker'          => new bs4Navwalker(),
    
            ));
            wp_nav_menu(
            array(
              'theme_location'  => 'mobile',
              'container_class' => '',
              'container_id'    => '',
              'menu_class'      => 'navigation collapse main-nav--mobile',
              'fallback_cb'     => '',
              'menu_id'         => 'navbarNavDropdown',
              // 'walker'          => new PPRS_Walker(),
              'walker'          => new bs4Navwalker(),
    
            ));  
          !!}
        @endif
      </nav>
    </div>       
  </div>

  <div class="header__search-bar" id="searchBar">
    @php get_product_search_form() @endphp
  </div>
</header>
