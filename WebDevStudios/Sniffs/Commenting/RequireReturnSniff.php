<?php

namespace WebDevStudios\Sniffs\Commenting;

use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_File;

class RequireReturnSniff extends BaseSniff {
	public $supportedTokenizers = [
		'PHP',
		// 'JS',
	];

	public function register() {
		return [

			/**
			 * PHP/JS Docblock.
			 *
			 * @link http://php.net/manual/en/language.basic-syntax.comments.php
			 */
			T_DOC_COMMENT_OPEN_TAG,
		];
	}

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
		$examine_return = $this->examine_return( $file, (object) [
			'doc_block_end' => $doc_block_end,
		] );

		if ( 'not_a_function' === $examine_return ) {

			// The code after the docblock isn't a function, so this doesn't matter.
			return;
		}

		error_log( print_r( array( $examine_return ), true ) );

		if ( ! $have_an_at_return_tag && 'has_return_statement' === $examine_return ) {
			return $this->record( (object) [
				'message' => 'You have no @return tag, but there is a return statement in your function.',
				'start'   => $doc_block_end,
				'error'   => 'Missing',
				'metric'  => 'yes',
			], $file );
		}

		if ( $have_an_at_return_tag && 'no_return_statement' === $examine_return ) {
			return $this->record( (object) [
				'message' => 'You have an @return tag, but no return statement found.',
				'start'   => $doc_block_end,
				'error'   => 'Missing',
				'metric'  => 'yes',
			], $file );
		}
	}

	protected function examine_return( &$file, $args ) {

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
		$function_end = $function_start['bracket_closer'];

		// Find a return; statement in the scope.
		$return = $file->findNext( T_RETURN, $function_start, $function_end, true );

		// Ensure our return is the right type too.
		$return = ( 'T_RETURN' === $this->get_token( $return, 'type' ) );

		return $return ? 'has_return_statement' : 'no_return_statement';
	}
}
