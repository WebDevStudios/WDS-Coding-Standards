<?php

namespace WebDevStudios\Sniffs\Commenting;

use PHP_CodeSniffer_Sniff;

abstract class BaseSniff implements PHP_CodeSniffer_Sniff {
	protected $tokens;

	protected function record( $args, &$phpcs_file ) {
		$phpcs_file->addError( $args->message, $args->start, $args->error );
		$phpcs_file->recordMetric( $args->start, $args->message, $args->metric );
	}

	protected function get_token( $position, $key = '' ) {
		if ( ! empty( $key ) ) {
			return $this->tokens[ $position ][ $key ];
		}

		return $this->tokens[ $position ];
	}
}
