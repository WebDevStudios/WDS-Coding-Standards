<?php // @codingStandardsIgnoreLine: Filename is ok.
/**
 * Shared functionality for all sub-classes.
 *
 * @since   1.1.0
 * @package WebDevStudios\Sniffs
 */

namespace WebDevStudios\Sniffs\All;
use PHP_CodeSniffer_Sniff;

/**
 * Base class for extending so you can get the below common tools.
 *
 * @since  1.1.0
 */
abstract class BaseSniff implements PHP_CodeSniffer_Sniff {

	/**
	 * The tokens.
	 *
	 * @author Aubrey Portwood
	 * @since  1.1.0
	 *
	 * @var array
	 */
	protected $tokens;

	/**
	 * Push an error to the console.
	 *
	 * @author Aubrey Portwood
	 * @since  1.1.0
	 *
	 * @param  PHP_CodeSniffer_File $file     The file.
	 * @param  int                  $where    Where the error happened.
	 * @param  string               $message  The message.
	 * @param  int                  $severity The severity, defaults to 0.
	 */
	protected function error( &$file, $where, $message, $severity = 0 ) {
		$this->console( (object) array(
			'message'  => $message,
			'start'    => $where,
			'log'      => 'error',
			'severity' => $severity,
		), $file );
	}

	/**
	 * Push a warning to the console.
	 *
	 * @author Aubrey Portwood
	 * @since  1.1.0
	 *
	 * @param  PHP_CodeSniffer_File $file     The file.
	 * @param  int                  $where    Where the warning happened.
	 * @param  string               $message  The message.
	 * @param  int                  $severity The severity, defaults to 0.
	 */
	protected function warn( &$file, $where, $message, $severity = 0 ) {
		$this->console( (object) array(
			'message'  => $message,
			'start'    => $where,
			'log'      => 'warning',
			'severity' => $severity,
		), $file );
	}

	/**
	 * Record something to the console.
	 *
	 * @author Aubrey Portwood
	 * @since  1.1.0
	 *
	 * @param array                $args {
	 *     Arguments.
	 *     @type string $message The message.
	 *     @type int    $start   The starting position of the record.
	 *     @type string $log     Whether to log an `error` or a `warning`.
	 * }
	 * @param PHP_CodeSniffer_File $phpcs_file The file.
	 *
	 * @return void Early bail when we finally log to the console.
	 */
	private function console( $args, &$phpcs_file ) {
		$args->log = strtolower( $args->log );

		// Create a unique error code for this message.
		$code = sha1( $args->message );

		if ( stristr( $args->log, 'error' ) ) {

			// Log as an error.
			$phpcs_file->addError( $args->message, $args->start, $code, array(), $args->severity );
			return;
		}

		if ( stristr( $args->log, 'warning' ) ) {

			// Log as a warning.
			$phpcs_file->addWarning( $args->message, $args->start, $code, array(), $args->severity );
			return;
		}
	}

	/**
	 * Get token.
	 *
	 * @author Aubrey Portwood
	 * @since  1.1.0
	 *
	 * @param int    $position The position of the token.
	 * @param string $key      The key you want from the array daya, leave empty to get all data.
	 *
	 * @return mixed An array of data if you request all information, any type given the key may be any type in the array.
	 */
	protected function get_token( $position, $key = '' ) {
		if ( ! empty( $key ) && isset( $this->tokens[ $position ][ $key ] ) ) {
			return $this->tokens[ $position ][ $key ];
		}

		return $this->tokens[ $position ];
	}

	/**
	 * Wrapper for PHP_CodeSniffer_File->findNext() with validation.
	 *
	 * @param PHP_CodeSniffer_File $file The file.
	 * @param int                  $token      The token position.
	 * @param string               $token_type The token type for validation.
	 * @param int                  $start      The position to start searching.
	 * @param int                  $end        The position to stop searching.
	 * @param boolean              $trail      Whether to go past $end and search again.
	 *
	 * @return boolean|mixed False if the token type did not validate, the value of findNext else.
	 */
	protected function find_next( $file, $token, $token_type = null, $start, $end, $trail = false ) {

		// Do findNext.
		$t = $file->findNext( $token, $start, $end, $trail );

		// Validate it.
		$valid = $token_type === $this->get_token( $t, 'type' );

		if ( $token_type && ! $valid ) {

			// Not valid.
			return false;
		}

		return $t;
	}
}
