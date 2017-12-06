<?php // @codingStandardsIgnoreLine: Filename is ok.
/**
 * Require the return tag.
 *
 * This requires the return tag when you have an return statement
 * inside of the function.
 *
 * @since   1.1.0
 * @package WebDevStudios\Sniffs
 */

namespace WebDevStudios\Sniffs\All;
use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

/**
 * Require the return tag.
 *
 * @author Aubrey Portwood
 * @since  1.1.0
 */
class RequireReturnSniff extends BaseSniff {

	/**
	 * What are we parsing?
	 *
	 * @author Aubrey Portwood
	 * @since  1.1.0
	 *
	 * @var array
	 */
	public $supportedTokenizers = [ // @codingStandardsIgnoreLine: camelCase required here.
		'PHP',
		'JS',
	];

	/**
	 * Register on all docblock comments.
	 *
	 * @author Aubrey Portwood
	 * @since  1.1.0
	 *
	 * @return array List of tokens.
	 */
	public function register() {
		return [

			/**
			 * PHP/JS Docblock.
			 *
			 * @link http://php.net/manual/en/language.basic-syntax.comments.php
			 * @since 1.1.0
			 */
			T_DOC_COMMENT_OPEN_TAG,
		];
	}

	/**
	 * Process file.
	 *
	 * @author Aubrey Portwood
	 * @since  1.1.0
	 *
	 * @param  PHP_CodeSniffer_File $file            The file object.
	 * @param  int                  $doc_block_start Where the docblock starts.
	 * @return void                                  Skips errors when not working with functions.
	 */
	public function process( PHP_CodeSniffer_File $file, $doc_block_start ) {
		$this->tokens = $file->getTokens();
		$token = $this->tokens[ $doc_block_start ];
		$doc_block_end = $token['comment_closer'];

		// The @ return in the comment block, false by default.
		$have_an_at_return_tag = false;

		for ( $i = $doc_block_start; $i <= $doc_block_end; $i++ ) {
			if ( stristr( $this->tokens[ $i ]['content'], '@return' ) ) {

				// We found an @return in the block.
				$have_an_at_return_tag = $this->tokens[ $i ];
			}
		}

		// If this is a function, does it have a return;? If not, this will come back as true.
		$examine_function = $this->examine_function( $file, (object) [
			'doc_block_end' => $doc_block_end,
		] );

		if ( 'not_a_function' === $examine_function ) {

			// The code after the docblock isn't a function, so this doesn't matter.
			return;
		}

		if ( ! $have_an_at_return_tag && 'has_return_statement' === $examine_function ) {
			$this->error( $file, $doc_block_end, 'Please document your return for this function in an @return tag.' );
		}

		if ( $have_an_at_return_tag && 'no_return_statement' === $examine_function ) {
			$this->error( $file, $doc_block_end, 'Your function does not return anything, no need for @return tag.' );
		}
	}

	/**
	 * Examine a function, and get some context about whether it has a return statement or not.
	 *
	 * @param PHP_CodeSniffer_File $file The file.
	 * @param array                $args {
	 *     Arguments.
	 *     @type string $doc_block_end Where the docblock ends.
	 * }
	 *
	 * @since 1.1.0
	 * @return string Contextual information about the function (if it is a function).
	 */
	protected function examine_function( PHP_CodeSniffer_File &$file, $args ) {

		// See if we can find a function start.
		$function_start = $file->findNext( T_FUNCTION, $args->doc_block_end );

		if ( ! $function_start ) {

			// This isn't a function, so we're okay.
			return 'not_a_function';
		}

		$doc_block_end_line = $this->get_token( $args->doc_block_end, 'line' );
		$function_start_line = $this->get_token( $function_start, 'line' );

		if ( $function_start_line !== $doc_block_end_line + 1 ) {

			// This also isn't a function, it's okay.
			return 'not_a_function';
		}

		// This is where the function (it's a function) ends...
		$function_end = $this->get_token( $function_start, 'scope_closer' );

		// See if we can find a return in the function scope.
		$return = $this->find_next( $file, T_RETURN, 'T_RETURN', $function_start, $function_end );

		return $return ? 'has_return_statement' : 'no_return_statement';
	}
}
