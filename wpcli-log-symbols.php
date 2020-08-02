<?php
/**
 * File to bootstrap plugin.
 *
 * @package WPCLI_Log_Symbols
 */

// If WP_CLI class or set_logger method not found then return.
if ( ! class_exists( 'WP_CLI' ) || ! method_exists( 'WP_CLI', 'set_logger' ) ) {
	return;
}

$autoload = dirname( __FILE__ ) . '/vendor/autoload.php';

if ( ! file_exists( $autoload ) ) {
	return;
}

require_once $autoload;

// Creating object of Extended logger class.
$wp_cli_log_symbols = new WP_Cli_Log_Symbols( false );

WP_CLI::set_logger( $wp_cli_log_symbols );
