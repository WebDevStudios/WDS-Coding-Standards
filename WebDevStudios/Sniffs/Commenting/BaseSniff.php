<?php // @codingStandardsIgnoreLine: Filename is ok.
/**
 * Shared functionality for all sub-classes.
 *
 * @since  1.1
 * @package  WebDevStudios\Sniffs
 */

namespace WebDevStudios\Sniffs\Commenting;
use PHP_CodeSniffer_Sniff;

/**
 * Base class for extending so you can get common tools.
 *
 * @since  1.1
 */
abstract class BaseSniff implements PHP_CodeSniffer_Sniff {

	/**
	 * The tokens.
	 *
	 * @author Aubrey Portwood
	 * @since  1.1
	 *
	 * @var array
	 */
	protected $tokens;

	/**
	 * Record something.
	 *
	 * @author Aubrey Portwood
	 * @since  1.1
	 *
	 * @param array                $args {
	 *     Arguments.
	 *     @type string $message The message.
	 *     @type int    $start   The starting position of the record.
	 *     @type string $error   The simple error message.
	 *     @type string $metric  The text to record for the metric.
	 * }
	 * @param PHP_CodeSniffer_File $phpcs_file The file.
	 */
	protected function record( $args, &$phpcs_file ) {
		$phpcs_file->addError( $args->message, $args->start, $args->error );
		$phpcs_file->recordMetric( $args->start, $args->message, $args->metric );
	}

	/**
	 * Get token.
	 *
	 * @author Aubrey Portwood
	 * @since  1.1
	 *
	 * @param int    $position The position of the token.
	 * @param string $key      The key you want from the array daya, leave empty to get all data.
	 *
	 * @return mixed An array of data if you request all information, any type given the key may be any type in the array.
	 */
	protected function get_token( $position, $key = '' ) {
		if ( ! empty( $key ) ) {
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
