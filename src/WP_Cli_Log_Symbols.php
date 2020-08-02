<?php
/**
 * File to load custom logger for WP CLI.
 *
 * @package WPCLI_Log_Symbols
 */

use WP_CLI\Loggers\Base;

/**
 * Extend default logger to symbols with message.
 */
class WP_Cli_Log_Symbols extends Base {

	/**
	 * Info Symbol.
	 *
	 * @var string
	 */
	protected $info_symbol = 'ℹ️';

	/**
	 * Warning Symbol.
	 *
	 * @var string
	 */
	protected $warning_symbol = '⚠️';

	/**
	 * Success Symbol.
	 *
	 * @var string
	 */
	protected $success_symbol = '✅';

	/**
	 * Error Symbol.
	 *
	 * @var string
	 */
	protected $error_symbol = '❌';

	/**
	 * Constructor to set default settings.
	 *
	 * @param bool $in_color Whether or not to Colorize strings.
	 */
	public function __construct( $in_color ) {
		$this->in_color = $in_color;
	}

	/**
	 * Write an informational message to STDOUT.
	 *
	 * @param string $message Message to write.
	 */
	public function info( $message ) {
		$message_with_symbol = $this->info_symbol . '  ' . $message . "\n";

		$this->write( STDOUT, $message_with_symbol );
	}

	/**
	 * Write a success message, prefixed with "Success: ".
	 *
	 * @param string $message Message to write.
	 */
	public function success( $message ) {
		$message_with_symbol = $this->success_symbol . ' ' . $message . "\n";

		$this->write( STDOUT, $message_with_symbol );
	}

	/**
	 * Write a warning message to STDERR, prefixed with "Warning: ".
	 *
	 * @param string $message Message to write.
	 */
	public function warning( $message ) {
		$message_with_symbol = $this->warning_symbol . '  ' . $message . "\n";

		$this->write( STDERR, $message_with_symbol );
	}

	/**
	 * Write an message to STDERR, prefixed with "Error: ".
	 *
	 * @param string $message Message to write.
	 */
	public function error( $message ) {
		$message_with_symbol = $this->error_symbol . ' ' . $message . "\n";

		$this->write( STDERR, $message_with_symbol );
	}

	/**
	 * Similar to error( $message ), but outputs $message in a red box
	 *
	 * @param  array $message_lines Message to write.
	 */
	public function error_multi_line( $message_lines ) {

		// convert tabs to four spaces, as some shells will output the tabs as variable-length.
		$message_lines = array_map(
			function( $line ) {
				return str_replace( "\t", '    ', $line );
			},
			$message_lines
		);

		$longest = max( array_map( 'strlen', $message_lines ) );

		// write an empty line before the message.
		$empty_line = \cli\Colors::colorize( '%w%1 ' . str_repeat( ' ', $longest ) . ' %n' );
		$this->write( STDERR, "\n\t$empty_line\n" );

		foreach ( $message_lines as $line ) {
			$padding = str_repeat( ' ', $longest - strlen( $line ) );
			$line    = \cli\Colors::colorize( "%w%1 $line $padding%n" );
			$this->write( STDERR, "\t$line\n" );
		}

		// write an empty line after the message.
		$this->write( STDERR, "\t$empty_line\n\n" );
	}

}
