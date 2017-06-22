<?php

class WebDevStudios_Sniffs_Commenting_LongConditionClosingCommentSniff implements PHP_CodeSniffer_Sniff {

	/**
	 * A list of tokenizers this sniff supports.
	 *
	 * @var array
	 */
	public $supportedTokenizers = array( // @codingStandardsIgnoreLine
									'PHP',
									'JS',
								   );

	/**
	 * The openers that we are interested in.
	 *
	 * @var array(int)
	 */
	private static $_openers = array(
								 T_SWITCH,
								 T_IF,
								 T_FOR,
								 T_FOREACH,
								 T_WHILE,
								 T_TRY,
								 T_CASE,
								);

	/**
	 * The length that a code block must be before
	 * requiring a closing comment.
	 *
	 * @var int
	 */
	public $lineLimit = 20; // @codingStandardsIgnoreLine
  
	/**
	 * The format the end comment should be in.
	 *
	 * The placeholder %s will be replaced with the type of condition opener.
	 *
	 * @var string
	 */
	public $commentFormat = '// End %s.'; // @codingStandardsIgnoreLine

	public function register() {
		return array( T_CLOSE_CURLY_BRACKET );
	}

	public function process( PHP_CodeSniffer_File $phpcs_file, $stack_ptr ) {
		$tokens = $phpcs_file->getTokens();

		if ( isset( $tokens[ $stack_ptr ]['scope_condition'] ) === false ) {
			// No scope condition. It is a function closer.
			return;
		}

		$start_condition = $tokens[ $tokens[ $stack_ptr ]['scope_condition'] ];
		$start_brace	 = $tokens[ $tokens[ $stack_ptr ]['scope_opener'] ];
		$end_brace		 = $tokens[ $stack_ptr ];

		// die( '<pre>' . var_export( array( $start_condition, $tokens ), true ) );
		// We are only interested in some code blocks.
		if ( in_array( $start_condition['code'], self::$_openers ) === false ) {
			return;
		}

		if ( T_IF === $start_condition['code'] ) {
			// If this is actually an ELSE IF, skip it as the brace
			// will be checked by the original IF.
			$else = $phpcs_file->findPrevious( T_WHITESPACE, ($tokens[ $stack_ptr ]['scope_condition'] - 1), null, true );
			if ( T_ELSE === $tokens[ $else ]['code'] ) {
				return;
			}

			// IF statements that have an ELSE block need to use
			// "end if" rather than "end else" or "end elseif".
			do {
				$next_token = $phpcs_file->findNext( T_WHITESPACE, ($stack_ptr + 1), null, true );
				if ( T_ELSE === $tokens[ $next_token ]['code'] || T_ELSEIF === $tokens[ $next_token ]['code'] ) {
					// Check for ELSE IF (2 tokens) as opposed to ELSEIF (1 token).
					if ( T_ELSE === $tokens[ $next_token ]['code'] && isset( $tokens[ $next_token ]['scope_closer'] ) === false ) {
						$next_token = $phpcs_file->findNext( T_WHITESPACE, ($next_token + 1), null, true );
						if ( T_IF !== $tokens[ $next_token ]['code'] || false === isset( $tokens[ $next_token ]['scope_closer'] ) ) {
							// Not an ELSE IF or is an inline ELSE IF.
							break;
						}
					}

					if ( false === isset( $tokens[ $next_token ]['scope_closer'] ) ) {
						// There isn't going to be anywhere to print the "end if" comment
						// because there is no closer.
						return;
					}

					// The end brace becomes the ELSE's end brace.
					$stack_ptr = $tokens[ $next_token ]['scope_closer'];
					$end_brace = $tokens[ $stack_ptr ];
				} else {
					break;
				} // End if.
			} while ( isset( $tokens[ $next_token ]['scope_closer'] ) === true );
		} // End if.

		if ( T_TRY === $start_condition['code'] ) {
			// TRY statements need to check until the end of all CATCH statements.
			do {
				$next_token = $phpcs_file->findNext( T_WHITESPACE, ($stack_ptr + 1), null, true );
				if ( T_CATCH === $tokens[ $next_token ]['code'] ) {
					// The end brace becomes the CATCH's end brace.
					$stack_ptr = $tokens[ $next_token ]['scope_closer'];
					$end_brace = $tokens[ $stack_ptr ];
				} else {
					break;
				}
			} while ( true === isset( $tokens[ $next_token ]['scope_closer'] ) );
		}

		// Work backwards from start brace.
		$end_paren_token = $phpcs_file->findPrevious( array( T_CLOSE_PARENTHESIS ), ($stack_ptr - 1), null, true );
		$end_paren = $tokens [ $end_paren_token ];
		//$content = $phpcs_file->getTokensAsString( $start_brace['line'], $line_difference );
		//die( '<pre>' . var_export( $end_paren, true ) );

		$line_difference = ($end_brace['line'] - $start_brace['line']);
		$expected = sprintf( $this->commentFormat, $start_condition['content'] );
		$comment  = $phpcs_file->findNext( array( T_COMMENT ), $stack_ptr, null, false );

		if ( ( false === $comment ) || ( $tokens[ $comment ]['line'] !== $end_brace['line'] ) ) {
			if ( $line_difference >= $this->lineLimit ) {
				$error = 'End comment for long condition not found; expected "%s"';
				$data  = array( $expected );
				$fix   = $phpcs_file->addFixableError( $error, $stack_ptr, 'Missing', $data );
 
				if ( true === $fix ) {
					$next = $phpcs_file->findNext( T_WHITESPACE, ($stack_ptr + 1), null, true );
					if ( false !== $next && $tokens[ $next ]['line'] === $tokens[ $stack_ptr ]['line'] ) {
						$expected .= $phpcs_file->eolChar;
					}

					$phpcs_file->fixer->addContent( $stack_ptr, $expected );
				}
			}

			return;
		}

		if ( ($comment - $stack_ptr) !== 1 ) {
			$error = 'Space found before closing comment; expected "%s"';
			$data	= array( $expected );
			$phpcs_file->addError( $error, $stack_ptr, 'SpacingBefore', $data );
		}

		if ( trim( $tokens[ $comment ]['content'] ) !== $expected ) {
			$found = trim( $tokens[ $comment ]['content'] );
			$error = 'Incorrect closing comment; expected "%s" but found "%s"';
			$data	= array(
				$expected,
				$found,
			);

			$fix = $phpcs_file->addFixableError( $error, $stack_ptr, 'Invalid', $data );
			if ( true === $fix ) {
				$phpcs_file->fixer->replaceToken( $comment, $expected . $phpcs_file->eolChar );
			}

			return;
		}

	 } // End process().
}
