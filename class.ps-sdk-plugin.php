<?php

class PsSdkWpPlugin {

    private static $initiated = false;

    public static function init() {
        if (!self::$initiated) {
            self::init_hooks();
        }
    }

    /**
     * Initializes WordPress hooks
     */
    private static function init_hooks() {
        self::$initiated = true;

        if (!defined('PATH_BASE_DIR')) {
            require_once ABSPATH . 'ps-includes/MainImport.php';
        }

        logg(' >> PATH_BASE_DIR: ' . PATH_BASE_DIR);

        add_action('wp_footer', function() {
                    print_r(PSDB::getArray('select * from wp_users'));
                }
        );

        PSLogger::inst('XXX')->info('Hellllooooooooooooooo!');
    }

    /**
     * Attached to activate_{ plugin_basename( __FILES__ ) } by register_activation_hook()
     * @static
     */
    public static function plugin_activation() {
        logg(' + ACTIVATE');

        if (version_compare($GLOBALS['wp_version'], PSSDK_PLUGIN_MINIMUM_WP_VERSION, '<')) {
            load_plugin_textdomain('akismet');

            $message = '<strong>' . sprintf(esc_html__('Akismet %s requires WordPress %s or higher.', 'akismet'), AKISMET_VERSION, PSSDK_PLUGIN_MINIMUM_WP_VERSION) . '</strong> ' . sprintf(__('Please <a href="%1$s">upgrade WordPress</a> to a current version, or <a href="%2$s">downgrade to version 2.4 of the Akismet plugin</a>.', 'akismet'), 'https://codex.wordpress.org/Upgrading_WordPress', 'http://wordpress.org/extend/plugins/akismet/download/');

            Akismet::bail_on_activation($message);
        }
    }

    /**
     * Removes all connection options
     * @static
     */
    public static function plugin_deactivation() {
        logg(' - DEACTIVATE');
    }

}