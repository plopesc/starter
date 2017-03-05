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


$databases = array();

$config_directories[CONFIG_SYNC_DIRECTORY] = '../config/sync';

$settings['hash_salt'] = 'yJvPg5qipjncWjWUt4AZnBMbVc0Ec21St0RDU4FiniY2NeLzQt27zvK75O-m4hKs8yVxaY4yUA';

/**
 * Load services definition file.
 */
$settings['container_yamls'][] = __DIR__.'/services.yml';

$settings['file_scan_ignore_directories'] = [
  'node_modules',
  'bower_components',
];

/**
 * Load local development override configuration, if available.
 *
 * Use settings.local.php to override variables on secondary (staging,
 * development, etc) installations of this site. Typically used to disable
 * caching, JavaScript/CSS compression, re-routing of outgoing emails, and
 * other things that should not happen on development and testing sites.
 *
 * Keep this code block at the end of this file to take full effect.
 */

$settings['install_profile'] = 'standard';


$databases['default']['default'] = array(
  'database' => 'data',
  'username' => 'mysql',
  'password' => 'mysql',
  'prefix' => '',
  'host' => 'mysql',
  'port' => '3306',
  'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
  'driver' => 'mysql',
);

$settings['trusted_host_patterns'] = array(
  '^dev\.local$',
  '.*platform\.sh$',
);

// Set up specific settings files per environment.
$env_include = [
  'settings.platformsh.php' => ['platform.sh'],
  'settings.circleci.php' => ['circleci'],
];

$file_included = FALSE;
foreach ($env_include as $settings_file => $wildcards) {
  foreach ($wildcards as $wildcard) {
    if (strpos($_SERVER['HTTP_HOST'], $wildcard) !== FALSE) {
      include_once __DIR__ . '/' . $settings_file;
      $file_included = TRUE;
      break 2;
    }
  }
}

/**
 * If there is a local settings file, then include it.
 */
$local_settings = dirname(__FILE__) . '/settings.local.php';
if (!$file_included && file_exists($local_settings)) {
  include $local_settings;
}
