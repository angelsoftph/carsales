<?php
/**
 * Recommended way to include parent theme styles.
 * (Please see http://codex.wordpress.org/Child_Themes#How_to_Create_a_Child_Theme)
 *
 */  

function twenty_twenty_five_child_style() {
  wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
  wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style') );
  wp_enqueue_style( 'theme-style', get_stylesheet_directory_uri() . '/assets/css/style.css', [], '1.0', 'all' );
}
add_action( 'wp_enqueue_scripts', 'twenty_twenty_five_child_style' );

function enqueue_custom_assets() {
  // Enqueue Owl Carousel CSS
  wp_enqueue_style('owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css');
  wp_enqueue_style('owl-theme', 'https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.default.min.css');

  // Enqueue Owl Carousel JS
  wp_enqueue_script('owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js', [], null, true);

  // Enqueue Google Font
  wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap');

  // Enqueue GSAP
  wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js', [], null, true);

  wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.6.0.min.js', false, null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_assets');

function custom_search_filter($query) {
  if (!is_admin() && $query->is_main_query() && is_search()) {
    if ($query->get('post_type') === 'car') {
      // Check if 'colour' parameter exists in the query
      $colour = isset($_GET['colour']) ? sanitize_text_field($_GET['colour']) : '';

      // Check if 'on_sale' parameter exists in the query
      $on_sale = isset($_GET['on_sale']) ? sanitize_text_field($_GET['on_sale']) : '';

      $meta_query = $query->get('meta_query') ?: [];

      if (!empty($colour)) {
          $meta_query[] = [
              'key'     => 'colour',
              'value'   => $colour,
              'compare' => '='
          ];
      }

      if (!empty($on_sale) && in_array($on_sale, ['1', 'true'], true)) {
          $meta_query[] = [
              'key'     => 'on_sale',
              'value'   => '1',
              'compare' => '='
          ];
      }

      if (!empty($meta_query)) {
          $query->set('meta_query', $meta_query);
      }
    }
  }
}
add_action('pre_get_posts', 'custom_search_filter');
