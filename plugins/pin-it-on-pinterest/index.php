<?php

/*
Plugin Name: Pin It On Pinterest
Plugin URI: http://flauntyoursite.com/pin-it-on-pinterest
Version: 0.9
Author: Flaunt Your Site
Description: Pin It On Pinterest places a Pin It button at the end of your posts, and allows you to predetermine what gets "Pinned" at Pinterest.
Author URI: http://flauntyoursite.com
License: GPL3
*/

$plugin_path=WP_PLUGIN_DIR.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
$plugin_url=trailingslashit(plugins_url(basename(dirname(__FILE__))));

include($plugin_path.'class-pinterest.php');

?>