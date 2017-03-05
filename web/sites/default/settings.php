<?php

/**
 * Access control for update.php script.
 */
$update_free_access = FALSE;

/**
 * PHP settings.
 */
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.gc_maxlifetime', 200000);
ini_set('session.cookie_lifetime', 2000000);

/**
 * Fast 404 pages.
 */
$conf['404_fast_paths_exclude'] = '/\/(?:styles)\//';
$conf['404_fast_paths'] = '/\.(?:txt|png|gif|jpe?g|css|js|ico|swf|flv|cgi|bat|pl|dll|exe|asp)$/i';
$conf['404_fast_html'] = '<html xmlns="http://www.w3.org/1999/xhtml"><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL "@path" was not found on this server.</p></body></html>';

$local_settings = dirname(__FILE__) . '/settings.local.php';
if (file_exists($local_settings)) {
    include $local_settings;
}
$databases['default']['default'] = array (
  'database' => 'data',
  'username' => 'mysql',
  'password' => 'mysql',
  'prefix' => '',
  'host' => 'mariadb',
  'port' => '3306',
  'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
  'driver' => 'mysql',
);
$settings['hash_salt'] = 'fSSUl8eWgKhycAc5yiCVY-lCopEi8vRl68Uk-0EVt3uRdAtvYXjz1wV44HUZ4tGQto_YamhtyA';
$settings['install_profile'] = 'standard';
$config_directories['sync'] = 'sites/default/files/config_JYzi_ZUn78__8JTSBNopik9aW6kJQlLjo8J37zG04xzeKEpJJ9NkRP9q85onx1HO5le0tUL79g/sync';
