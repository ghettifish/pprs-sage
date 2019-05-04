@php function cart_count() {
	$cartcount = WC()->cart->get_cart_contents_count();
	if($cartcount > 0) { return $cartcount; };
}

// Filter wp_nav_menu() to add additional links and other output
function nav_actions($items) {
	$li = '<li class="main-nav__item--0">';
	$a = '<a class="header__cart" href="';
	$close_a = '">';
	$close_li='</li>';
    $view_cart = $li . $a . wc_get_page_permalink('cart') . $close_a . __('Cart | ') . '<i class="fas fa-shopping-cart"></i> '. cart_count() . '</a>';
	$login = $li . $a . wc_get_page_permalink('myaccount') . $close_a . __('Login/Register ') . '<i class="fas fa-user"></i></a>';
	$search = $li . '<i class="fas fa-search header__search-icon" id="toggleSearch"></i>' . $close_li;
	$action = is_user_logged_in() ? $view_cart : $login ;
    $items = $items . $action . $search;
    return $items;
}
add_filter( 'wp_nav_menu_items', 'nav_actions' );

@endphp

<header class="container main-nav__container" id="banner">
  @if(has_custom_logo()) 
    <div class="row">
        <div class="col-4">
          <?php the_custom_logo(); ?>
        </div>
        <div class="col-4 d-flex align-items-center justify-content-end">
        
          <button class="navbar-toggler" id="navbarToggle" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            Menu
          </button>
        </div>
      </div>
    </div>
  @endif

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
  <div class="header__search-bar" id="searchBar">
    @php get_product_search_form() @endphp
  </div>
</header>
