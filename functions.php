<?php
function get_theme_version() {
  return wp_get_theme()->get('Version');
}

function custom_theme_assets() {
  $theme_version = get_theme_version();

  wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css', array(), $theme_version);
  wp_enqueue_style('custom-css', get_template_directory_uri() . '/assets/css/style.css', array(), $theme_version);
  wp_enqueue_style('fonts-css', get_template_directory_uri() . '/assets/fonts/icomoon/style.css', array(), $theme_version);
  wp_enqueue_style('menu-css', get_template_directory_uri() . '/assets/css/menu.css', array(), $theme_version);
  
  
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery-js', 'https://code.jquery.com/jquery-3.7.1.js', array('jquery'), $theme_version, true);

  wp_enqueue_script('popper', 'https://cdn.jsdelivr.net/npm/popper.js@2.11.6/dist/umd/popper.min.js', array('jquery'), $theme_version, true);
  wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js', array('jquery', 'popper'), $theme_version, true);
  wp_enqueue_script('jquerysticky-js', get_template_directory_uri() . '/assets/js/jquery.sticky.js', array('jquery'), $theme_version, true);
  wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), $theme_version, true);
  
  wp_localize_script('main-js', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}

add_action('wp_enqueue_scripts', 'custom_theme_assets');

  // bootstrap 5 wp_nav_menu walker
  class bootstrap_5_wp_nav_menu_walker extends Walker_Nav_menu
  {
    private $current_item;
    private $dropdown_menu_alignment_values = [
      'dropdown-menu-start',
      'dropdown-menu-end',
      'dropdown-menu-sm-start',
      'dropdown-menu-sm-end',
      'dropdown-menu-md-start',
      'dropdown-menu-md-end',
      'dropdown-menu-lg-start',
      'dropdown-menu-lg-end',
      'dropdown-menu-xl-start',
      'dropdown-menu-xl-end',
      'dropdown-menu-xxl-start',
      'dropdown-menu-xxl-end'
    ];
  
    function start_lvl(&$output, $depth = 0, $args = null)
    {
      $dropdown_menu_class[] = '';
      foreach($this->current_item->classes as $class) {
        if(in_array($class, $this->dropdown_menu_alignment_values)) {
          $dropdown_menu_class[] = $class;
        }
      }
      $indent = str_repeat("\t", $depth);
      $submenu = ($depth > 0) ? ' sub-menu' : '';
      $output .= "\n$indent<ul class=\"dropdown-menu$submenu " . esc_attr(implode(" ",$dropdown_menu_class)) . " depth_$depth\">\n";
    }
  
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
      $this->current_item = $item;
  
      $indent = ($depth) ? str_repeat("\t", $depth) : '';
  
      $li_attributes = '';
      $class_names = $value = '';
  
      $classes = empty($item->classes) ? array() : (array) $item->classes;
  
      $classes[] = ($args->walker->has_children) ? 'dropdown' : '';
      $classes[] = 'nav-item';
      $classes[] = 'nav-item-' . $item->ID;
      if ($depth && $args->walker->has_children) {
        $classes[] = 'dropdown-menu dropdown-menu-end';
      }
  
      $class_names =  join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
      $class_names = ' class="' . esc_attr($class_names) . '"';
  
      $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
      $id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';
  
      $output .= $indent . '<li ' . $id . $value . $class_names . $li_attributes . '>';
  
      $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
      $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
      $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
      $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
  
      $active_class = ($item->current || $item->current_item_ancestor || in_array("current_page_parent", $item->classes, true) || in_array("current-post-ancestor", $item->classes, true)) ? 'active' : '';
      $nav_link_class = ( $depth > 0 ) ? 'dropdown-item ' : 'nav-link ';
      $attributes .= ( $args->walker->has_children ) ? ' class="'. $nav_link_class . $active_class . ' dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : ' class="'. $nav_link_class . $active_class . '"';
  
      $item_output = $args->before;
      $item_output .= '<a' . $attributes . '>';
      $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
      $item_output .= '</a>';
      $item_output .= $args->after;
  
      $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
  }
  // register a new menu
  register_nav_menu('main-menu', 'Main menu');

function load_page_content($template_name) {
    ob_start();
    get_template_part($template_name);
    $content = ob_get_clean();
    echo $content;
    wp_die();
}

// Carregar conteúdo da página de contato
add_action('wp_ajax_nopriv_load_contact_page_content', function () {
    load_page_content('page-contact');
});
add_action('wp_ajax_load_contact_page_content', function () {
    load_page_content('page-contact');
});

// Carregar conteúdo da página de serviço
add_action('wp_ajax_nopriv_load_servic_page_content', function () {
    load_page_content('page-servic');
});
add_action('wp_ajax_load_servic_page_content', function () {
    load_page_content('page-servic');
});
