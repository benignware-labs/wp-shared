<?php

/**
 * Plugin Name: Shared
 * Plugin URI: https://github.com/benignware-labs/wp-shared
 * Description: Share stuff on social media
 * Author: Rafael Nowrotek
 * Author URI: http://benignware.com/
 * Version: 0.0.1
 *
 */

require_once plugin_dir_path( __FILE__ ) . 'lib/options.php';
require_once plugin_dir_path( __FILE__ ) . 'lib/utils.php';
require_once plugin_dir_path( __FILE__ ) . 'lib/functions.php';

add_action('wp_enqueue_scripts', function() {
  // Scripts
  wp_register_script( 'shared-js', plugin_dir_url( __FILE__ ) . '/dist/shared.js');
	wp_localize_script( 'shared-js', 'SharedSettings',
    array(
			'data' => json_encode(array(
				'options' => get_shared_options()
			))
    )
  );
  wp_enqueue_script( 'shared-js');

  // Styles
  wp_enqueue_style( 'shared-css', plugin_dir_url( __FILE__ ) . '/dist/shared.css');
  wp_enqueue_style( 'fontawesome-css', plugin_dir_url( __FILE__ ) . '/dist/fontawesome/css/all.min.css');
}, 10);

add_action('the_content', function($content) {
  global $post;

  if (!is_single()) {
    return $content;
  }

  $options = get_shared_options();

  $blog_name = get_bloginfo('name');

  $data = [
    'blog_name' => $blog_name,
    'site_url' => site_url(),
    'title' => $post ? get_the_title($post) : $blogname,
    'permalink' => $post ? get_permalink($post) : $blogname
  ];

  $data = array_reduce(array_keys($data), function($result, $key) use ($data) {
    $result['%' . $key] = $data[$key];

    return $result;
  }, array());

  $services = get_shared_services();
  $services = array_map(function($pattern) use ($data) {
    return str_replace(array_keys($data), array_values($data), $pattern);
  }, $services);

  $services = array_filter($services, function($key) use ($options) {
    return in_array($key, array_keys($options['services']));
  }, ARRAY_FILTER_USE_KEY);

  $html = wp_shared_render_template($options['template'], $options['format'], [
    'options' => $options,
    'services' => $services
  ]);

  return $html . $content;

}, 10);


add_filter('shared_icon_class', function($class, $name) {
  switch ($name) {
    case 'rss':
      return 'fas fa-' . $name;
    case 'facebook':
      return 'fab fa-' . $name . '-f';
    case 'linkedin':
      return 'fab fa-' . $name . '-in';
    case 'reddit':
      return 'fab fa-' . $name . '-alien';
    default:
      return 'fab fa-' . $name;
  }
}, 1, 2);
