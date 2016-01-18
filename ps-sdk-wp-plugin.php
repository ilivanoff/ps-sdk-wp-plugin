<?php

/*
  Plugin Name: Ps SDK Plugin
  ; Plugin URI: http://ivanovilya.com/
  Description: Планиг включает в работу классы ps-sdk.
  Version: 1.0
  Author: ilivanoff
  Author URI: http://ivanovilya.com/
  License: GPL or later
  Text Domain: ps-sdk
 */

/* Copyright 2016  Ivanov Ilya  (info@ivanovilya.com)

  This program is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License
  as published by the Free Software Foundation; either version 2
  of the License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

// Make sure we don't expose any info if called directly
// Same code as PsUtil::isWordPress()
if (!function_exists('add_action') || !defined('ABSPATH')) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

define('PSSDK_PLUGIN_VERSION', '1.0');
define('PSSDK_PLUGIN_MINIMUM_WP_VERSION', '5.2');
define('PSSDK_PLUGIN_URL', plugin_dir_url(__FILE__));
define('PSSDK_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PSSDK_PLUGIN_LOG', PSSDK_PLUGIN_DIR . 'log.txt');

if (version_compare($GLOBALS['wp_version'], PSSDK_PLUGIN_MINIMUM_WP_VERSION, '<')) {
    $message = sprintf('Ps sdk plugin %s requires WordPress %s or higher.', AKISMET_VERSION, PSSDK_PLUGIN_MINIMUM_WP_VERSION);
    die($message);
}

function logg($msg) {
    @file_put_contents(PSSDK_PLUGIN_LOG, ($msg ? $msg : '') . "\n", FILE_APPEND);
}

logg((@filesize(PSSDK_PLUGIN_LOG) ? "\n\n" : '') . str_pad(time(), 60, '=', STR_PAD_BOTH));
logg('REQUEST:' . print_r($_REQUEST, true));
logg('__FILE__: ' . __FILE__);
logg('PSSDK_PLUGIN_DIR: ' . PSSDK_PLUGIN_DIR);
logg('PSSDK_PLUGIN_URL: ' . PSSDK_PLUGIN_URL);

register_activation_hook(__FILE__, array('PsSdkWpPlugin', 'plugin_activation'));
register_deactivation_hook(__FILE__, array('PsSdkWpPlugin', 'plugin_deactivation'));

require_once( PSSDK_PLUGIN_DIR . 'class.ps-sdk-plugin.php' );
//require_once( AKISMET__PLUGIN_DIR . 'class.akismet-widget.php' );

add_action('init', array('PsSdkWpPlugin', 'init'));
/*
if ( is_admin() ) {
	require_once( AKISMET__PLUGIN_DIR . 'class.akismet-admin.php' );
	add_action( 'init', array( 'Akismet_Admin', 'init' ) );
}

//add wrapper class around deprecated akismet functions that are referenced elsewhere
require_once( AKISMET__PLUGIN_DIR . 'wrapper.php' );
*/