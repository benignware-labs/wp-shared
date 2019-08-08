<?php


// Uncomment for ebugging
// delete_option('shared_options');

// Create custom plugin settings menu
add_action('admin_menu', 'shared_create_menu');

function shared_create_menu() {
  // Create new top-level menu
  add_options_page(__('Shared Settings'), __('Shared'), 'administrator', __FILE__, 'shared_settings_page' , plugins_url('/images/icon.png', __FILE__) );

  // Call register settings function
  add_action( 'admin_init', 'register_shared_settings' );
}

function register_shared_settings() {
  // Register our settings

  register_setting( 'shared-settings-group', 'shared_options', array(
    'default' => array(
      'selector' => '#content',
      'services' => array_map(function($service) {
        return true;
      }, get_shared_services())
    )
  ));
}


function shared_settings_page() {
  $options = get_option('shared_options');
  // Set variables
  $services = get_shared_services();
  $services = array_reduce(array_keys($services), function($result, $key) use ($services, $options) {
    $result[$key] = isset($options['services'][$key]) && $options['services'][$key] ? 1 : 0;

    return $result;
  }, array());
?>
<div class="wrap">
<h2>Shared</h2>
<p>Share stuff on social media</p>
<form method="post" action="options.php">
    <?php settings_fields( 'shared-settings-group' ); ?>
    <?php do_settings_sections( 'shared-settings-group' ); ?>
    <table class="form-table">
      <tr>
        <th scope="row"><?= __('Selector'); ?></th>
        <td>
          <input type="text" name="shared_options[selector]" value="<?php echo esc_attr( $options['selector'] ); ?>" />
        </td>
      </tr>
      <tr>
        <th><?= __('Services'); ?></th>
        <td>
          <table cellspacing="0" cellspacing="0">
            <?php foreach ($services as $name => $value): ?>
              <tr>
                <td>
        					<label>
        						<input type="checkbox" name="shared_options[services][<?= $name; ?>]" value="1" <?php checked( $value, 1 ); ?> />
        						<?= __($name); ?>
        					</label>
                </td>
              </tr>
            <?php endforeach; ?>
          </table>
        </td>
      </tr>
    </table>
    <?php submit_button(); ?>
  </form>
</div>
<?php
}
