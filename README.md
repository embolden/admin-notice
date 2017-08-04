# Admin Notice
Admin Notice is a WordPress helper class that allows you to create a customizable notice in the WordPress admin without the need for a dedicated callback function.

## Usage Example
```php
require_once( 'class-admin-notice.php' );

class My_Plugin {
  $php_version = '5.4.0';

  $wordpress_version = '4.8.0';

  function __construct() {
    add_action( 'admin_init', array( $this, 'check_versions' ) );
  }

  function check_versions() {
    if ( version_compare( PHP_VERSION, $this->php_version, '<' ) ) {
      new Admin_Notice( sprintf( 'My Plugin requires PHP version %1$s.', $this->php_version ) );
    }

    if( version_compare( get_bloginfo( 'version' ), $this->wordpress_version, '<' ) ) {
      new Admin_Notice( sprintf( 'My Plugin requires WordPress version %1$s.', $this->wordpress_version ) );
    }
  }

}
```

## Filters

### admin_notice_valid_notice_types
WordPress has four notice classes:  
- `notice-error` will display a white background with a ![#dc3232](https://placehold.it/15/dc3232/000000?text=+) **red** left border
- `notice-info` will display a white background with a ![#00a0d2](https://placehold.it/15/00a0d2/000000?text=+) **blue** left border
- `notice-success` will display a white background with a ![#46b450](https://placehold.it/15/46b450/000000?text=+) **green** left border
- `notice-warning` will display a white background with a ![#ffb900](https://placehold.it/15/ffb900/000000?text=+) **yellow** left border

Admin Notice will default to `notice-error` if no notice is provided or an unlisted class is provided.  This filter allows you to modify that filtering for any custom admin CSS classes that you might have.  You will need to follow the [Codex's](https://codex.wordpress.org/Creating_Admin_Themes) instructions on enqueuing your custom CSS. 

#### Usage
```php
add_filters( 'admin_notice_valid_notice_types', $valid_notice_types );

function add_custom_notice_type_class( $valid_notice_types ) {
  $valid_notice_types[] = 'notice-custom';

  return $valid_notice_types;
}
```
