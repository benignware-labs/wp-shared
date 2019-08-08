<?php

function get_shared_options() {
  $options = apply_filters('shared_options', array_merge(
    array(
      'selector' => '#content',
      'template' => 'shared',
      'format' => '',
      'services' => ''
    ),
    get_option('shared_options') ?: []
  ));

  return $options;
}

function get_shared_services() {
  return apply_filters('shared_services', [
    'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=%permalink',
    'twitter' => 'https://twitter.com/intent/tweet?text=%title&url=%permalink&via=%blog_name',
    'linkedin' => 'https://www.linkedin.com/shareArticle?mini=true&url=%permalink&title=%title',
    'reddit' => 'http://www.reddit.com/submit?url=%permalink',
    'whatsapp' => 'whatsapp://send?text=%title %permalink',
    // 'buffer' => 'https://bufferapp.com/add?url=%permalink&text=%title',
    'rss' => '%site_url/feed'
  ]);
}

function shared_icon($name) {
  $icon_class = apply_filters('shared_icon_class', 'icon-' . $name, $name);

  //$icon_class = 'fab fa-' . $name;
  $html = '<i class="' . $icon_class  . '"></i>';

  return apply_filters('shared_icon_html', $html);
}
