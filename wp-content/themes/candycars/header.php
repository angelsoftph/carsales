<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Candy Car Sales</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<div id="content" class="container site-content">
    <div class="row header">
      <div class="col-12 col-md-3">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><div id="logo"></div></a>
      </div>
      <div class="col-12 col-md-9">
        <?php
          wp_nav_menu([
            'theme_location' => 'primary',
            'menu_id'        => 'primary-menu',
            'container'      => 'nav',
            'container_class'=> 'primary-navigation',
            'menu_class'     => 'menu-primary',
          ]);
        ?>
      </div>
    </div>
    <div class="filters">
      <form role="search" method="get" id="searchform" action="">
        <div>
          <input type="text" class="form-control" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="Search..." />
        </div>
        <div>
          <select name="colour" id="colour" class="form-control">
            <option value=""><?php _e('All Colours', 'your-textdomain'); ?></option>
            <option value="Black" <?php selected('Black', get_query_var('colour')); ?>>Black</option>
            <option value="Green" <?php selected('Green', get_query_var('colour')); ?>>Green</option>
            <option value="Orange" <?php selected('Orange', get_query_var('colour')); ?>>Orange</option>
            <option value="Red" <?php selected('Red', get_query_var('colour')); ?>>Red</option>
            <option value="White" <?php selected('White', get_query_var('colour')); ?>>White</option>
          </select>
        </div>
        <div>
          <select name="on_sale" id="on_sale" class="form-control">
            <option value="">On Sale?</option>
            <option value="1" <?php selected(get_query_var('on_sale'), '1'); ?>>Yes</option>
            <option value="0" <?php selected(get_query_var('on_sale'), '0'); ?>>No</option>
          </select>
        </div>
        <div>
          <input type="hidden" name="post_type" value="car" />
          <button type="submit"><?php _e('Search', 'your-textdomain'); ?></button>
        </div>
      </form>
    </div>
