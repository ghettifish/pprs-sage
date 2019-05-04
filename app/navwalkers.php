<?php

class PPRS_Walker extends Walker_Nav_Menu {
    var $tree_type = array('post_type', 'taxonomy', 'custom');
    var $db_fields = array('parent' => 'menu_item_parent', 'id' => 'db_id');
  
    //This col_check is used to see if the columns menu item is currently being setup.
    //There might be a more elagant solution, but I couldn't find anything else to use
    //as an evaluation of whether to setup a column menu or not.
    var $col_check = false;
  
    public function start_lvl(&$output, $depth = 0, $args = array()) {
      global $col_check;
      $ul_type =  $col_check ? "col-nav": "main-nav";
      $indent = str_repeat("\t", $depth);
          $output .= "\n$indent<ul class=\"animated ". $ul_type . "__sub-menu--$depth\">\n";
          $this;
    }
  
    function start_el(&$output, $object, $depth=0, $args=array(), $current_object_id = 0) {
      global $col_check;
      $explode_title = explode(" ",strtolower($object->title));
      $clean_title = implode("-", $explode_title);
      $columnChecker = array("minerals","bulk","display","polished", "tumbled-stone");
      $col_check = in_array($clean_title, $columnChecker)  ? true : false;
      $columns = array("Bulk","Display","Polished");
      $parents = array("5525","5530", "5553", "5584", "5595");
  
      $nav_container = in_array($object->menu_item_parent, $parents) ? "col-nav" : "main-nav";
      switch($depth) {
  
        case 0:
          $menu_type = $object->title == "Minerals" ? "col-nav" : "main-nav";
          $output .= nav_link($object, $clean_title, $depth, $menu_type);
         break;
  
        case 1:
          if( in_array($object->title, $columns) ) {
            $output .="<div class='col-nav__col'>";
            $output .= nav_link($object, $clean_title, $depth, $nav_container);
          } elseif( in_array($object->menu_item_parent, $parents)) {
            $output .= nav_link($object, $clean_title, $depth, $nav_container);
          } else {
            $output .= nav_link($object, $clean_title, $depth, $nav_container);
          }
          break;
        case 2:
          $output .= nav_link($object, $clean_title, $depth, $nav_container);
          break;
        default :
          $output .= nav_link($object, $clean_title, $depth, $nav_container);
          break;
      }
    }
  
    function end_el(&$output, $object, $depth=0, $args=array()) {
      $columnHeaders = array("Bulk","Display","Tumbled Stone");
      $output .= in_array($object->title, $columnHeaders) ? "</li></div>" : "</li>";
    }
  }
  
  function nav_link($object, $clean_title, $depth, $nav_container = "",  $class_name = "") {
    return <<<HTML
    <li class='{$nav_container}__item--{$depth} {$class_name} {$clean_title}'>
      <a href='{$object->url}' class='{$nav_container}__link--{$depth}'>
        {$object->title}
      </a>
HTML;
//Don't mess with this HTML http://php.net/manual/en/language.types.string.php#language.types.string.syntax.heredoc
}


class bs4Navwalker extends Walker_Nav_Menu
{
    /**
     * Starts the list before the elements are added.
     *
     * @see Walker::start_lvl()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class=\"dropdown-menu\">\n";
    }

    /**
     * Ends the list of after the elements are added.
     *
     * @see Walker::end_lvl()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</div>\n";
    }

    /**
     * Start the element output.
     *
     * @see Walker::start_el()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     * @param int    $id     Current item ID.
     */
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        /**
         * Filter the CSS class(es) applied to a menu item's list item element.
         *
         * @since 3.0.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
         * @param object $item    The current menu item.
         * @param array  $args    An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth   Depth of menu item. Used for padding.
         */
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );

        // New
        $class_names .= ' nav-item';
        
        if (in_array('menu-item-has-children', $classes)) {
            $class_names .= ' dropdown';
        }

        if (in_array('current-menu-item', $classes)) {
            $class_names .= ' active';
        }
        //

        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        // print_r($class_names);

        /**
         * Filter the ID applied to a menu item's list item element.
         *
         * @since 3.0.1
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
         * @param object $item    The current menu item.
         * @param array  $args    An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth   Depth of menu item. Used for padding.
         */
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        // New
        if ($depth === 0) {
            $output .= $indent . '<li' . $id . $class_names .'>';
        }
        //

        // $output .= $indent . '<li' . $id . $class_names .'>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        // New
        if ($depth === 0) {
            $atts['class'] = 'nav-link';
        }

        if ($depth === 0 && in_array('menu-item-has-children', $classes)) {
            $atts['class']       .= ' dropdown-toggle';
            $atts['data-toggle']  = 'dropdown';
        }

        if ($depth > 0) {
            $manual_class = array_values($classes)[0] .' '. 'dropdown-item';
            $atts ['class']= $manual_class;
        }

        if (in_array('current-menu-item', $item->classes)) {
            $atts['class'] .= ' active';
        }
        // print_r($item);
        //

        /**
         * Filter the HTML attributes applied to a menu item's anchor element.
         *
         * @since 3.6.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array $atts {
         *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
         *
         *     @type string $title  Title attribute.
         *     @type string $target Target attribute.
         *     @type string $rel    The rel attribute.
         *     @type string $href   The href attribute.
         * }
         * @param object $item  The current menu item.
         * @param array  $args  An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth Depth of menu item. Used for padding.
         */
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;
        // New
        /*
        if ($depth === 0 && in_array('menu-item-has-children', $classes)) {
            $item_output .= '<a class="nav-link dropdown-toggle"' . $attributes .'data-toggle="dropdown">';
        } elseif ($depth === 0) {
            $item_output .= '<a class="nav-link"' . $attributes .'>';
        } else {
            $item_output .= '<a class="dropdown-item"' . $attributes .'>';
        }
        */
        //
        $item_output .= '<a'. $attributes .'>';
        /** This filter is documented in wp-includes/post-template.php */
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        /**
         * Filter a menu item's starting output.
         *
         * The menu item's starting output only includes `$args->before`, the opening `<a>`,
         * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
         * no filter for modifying the opening and closing `<li>` for a menu item.
         *
         * @since 3.0.0
         *
         * @param string $item_output The menu item's starting HTML output.
         * @param object $item        Menu item data object.
         * @param int    $depth       Depth of menu item. Used for padding.
         * @param array  $args        An array of {@see wp_nav_menu()} arguments.
         */
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    /**
     * Ends the element output, if needed.
     *
     * @see Walker::end_el()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Page data object. Not used.
     * @param int    $depth  Depth of page. Not Used.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    public function end_el( &$output, $item, $depth = 0, $args = array() ) {
        if ($depth === 0) {
            $output .= "</li>\n";
        }
    }
}
