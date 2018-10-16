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
	 * @param string $key      The key you want from the array data, leave empty to get all data.
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
	 * Get the position the token's content ends.
	 *
	 * @author Aubrey Portwood <aubrey@webdevstudios.com>
	 * @since  1.2.0
	 *
	 * @param  array $token  Token.
	 * @return int           The position.
	 */
	protected function get_comment_token_closer_position( $token ) {
		return isset( $token['comment_closer'] ) ? $token['comment_closer'] : 0;
	}

	/**
	 * Get a token's content.
	 *
	 * @author Aubrey Portwood <aubrey@webdevstudios.com>
	 * @since  1.2.0
	 *
	 * @param  array $token  Token.
	 * @return string        The content.
	 */
	protected function get_token_content( $token ) {
		return isset( $token['content'] ) ? $token['content'] : '';
	}

	/**
	 * Wrapper for PHP_CodeSniffer_File->findNext() with validation.
	 *
	 * @param PHP_CodeSniffer_File $file       The file.
	 * @param int                  $token_type The token type e.g. from http://php.net/manual/en/tokens.php.
	 * @param string               $validate   The token type for validation..
	 * @param int                  $start      The position to start searching.
	 * @param int                  $end        The position to stop searching.
	 * @param boolean              $local      Whether to go past $end and search again.
	 *
	 * @return boolean|mixed False if the token type did not validate, the value of findNext else.
	 *
	 * @see  https://pear.php.net/package/PHP_CodeSniffer/docs/3.2.3/apidoc/PHP_CodeSniffer/File.html#methodfindNext
	 */
	protected function find_next( $file, $token_type, $validate = null, $start, $end = null, $local = false ) {

		// Do findNext.
		$t = $file->findNext( $token_type, $start, $end, $local );

		// Validate it.
		$valid = $validate === $this->get_token( $t, 'type' );
		if ( $validate && ! $valid ) {

			// Not valid.
			return false;
		}

		return $t;
	}

	/**
	 * Find out if the given token type is on the next line.
	 *
	 * @author Aubrey Portwood <aubrey@webdevstudios.com>
	 * @since  1.2.0
	 *
	 * @param  PHP_CodeSniffer_File $file File.
	 * @param  int $token_type The        Token Type Code.
	 * @param  string $token_name         The token name e.g. T_FUNCTION for validation.
	 * @param  int $position              The position of the current token.
	 * @return boolean                    True if, on the next line, that token type is found.
	 */
	protected function next_line_is_token_type( $file, $token_type, $token_name, $position ) {
		$token    = $this->get_token( $position );
		$function = $this->find_next( $file, $token_type, $token_name, $position );

		if ( $function ) {
			$function = $this->get_token( $function );
			if ( $function['line'] === $token['line'] + 1 ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Get the contents of a line.
	 *
	 * @author Aubrey Portwood <aubrey@webdevstudios.com>
	 * @since  1.2.0
	 *
	 * @param  object $file File object from PHPCS.
	 * @param  int    $line The line.
	 * @return string       The contents.
	 */
	protected function get_line_content( $file, $line ) {

		// The filename of the file.
		$filename = $file->getFilename();

		// Seek to the line.
		$spl = new \SplFileObject( $filename );
		$spl->seek( $line - 1 ); // Zero-based.

		// Get the content.
		return $spl->current();
	}

	/**
	 * Does the next line have content.
	 *
	 * @author Aubrey Portwood <aubrey@webdevstudios.com>
	 * @since  1.2.0
	 *
	 * @param  object $file     The file object from PHPCS.
	 * @param  string $text     The string to search for on that line.
	 * @param  int    $position The position of the token.
	 * @return bool             True if it does, false if not.
	 */
	protected function next_line_has( $file, $text, $position ) {
		$token = $this->get_token( $position );

		foreach ( $this->tokens as $t ) {
			if ( $token['line'] + 1 === $t['line'] ) {
				$content = $this->get_line_content( $file, $t['line'] );

				if ( stristr( $content, $text ) ) {
					return true;
				}
			}
		}

		return false;
	}
}
