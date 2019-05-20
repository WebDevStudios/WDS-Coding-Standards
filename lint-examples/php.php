<?php
/**
 * Examples (PHP)
 *
 * @since    Friday, May 3, 2019
 * @package  WebDevStudios\Sniffs
 */

/**
 * A function with no return.
 *
 * This function has a documented at-return but does not return anything.
 * Should also bark about not having at-author.
 * Should also bark about not having at-since.
 *
 * @return  string Something.
 */
function foo() {
}

/**
 * A function that returns something.
 *
 * This should bark about not having at-return.
 *
 * @author Aubrey Portwood <aubrey@webdevstudios.com>
 * @since  Friday, May 3, 2019
 */
function bar() {
	return 'something';
}
