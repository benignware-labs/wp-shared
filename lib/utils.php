<?php

function wp_shared_render_template($template, $format = '', $data = array()) {
	$is_absolute_path = $template[0] === DIRECTORY_SEPARATOR || preg_match('~\A[A-Z]:(?![^/\\\\])~i', $template) > 0;
	$path_parts = pathinfo($template);
  $template_name = $format ? $path_parts['filename'] . '-' . $format : $path_parts['filename'];
	$template_ext = isset($path_parts['extension']) ? $path_parts['extension'] : 'php';
	$template_base = $template_name . '.' . $template_ext;
	$template_dir = $path_parts['dirname'];

	if (!$is_absolute_path) {
		// Resolve template
		$directories = array(
			get_template_directory(),
      get_stylesheet_directory(),
			realpath(plugin_dir_path( __FILE__ ) . '../templates')
		);

		$template_dir = array_values(array_filter($directories, function($dir) use ($template_base) {
			return file_exists($dir . DIRECTORY_SEPARATOR . $template_base);
		}))[0];
	}

	$template_file = $template_dir . DIRECTORY_SEPARATOR . $template_base;

  foreach($data as $key => $value) {
    $$key = $data[$key];
  }
  ob_start();
  include $template_file;

  $output = ob_get_contents();

  ob_end_clean();
  return $output;
}
