/**
 * Custom WDS ESLint Rules.
 *
 * In order for this to work you need to:
 *
 *     npm install -g /path/to/eslint-plugin-webdevstudios
 */

/* globals module */
var wdscsUtils = ( function( wdscsUtils ) {

	/**
	 * Get the content of a node.
	 *
	 * @author Aubrey Portwood <aubrey@webdevstudios.com>
	 * @since  Friday, October 19, 2018
	 *
	 * @param  {Object} node The node.
	 * @return {String}      The content of the node.
	 */
	wdscsUtils.getNodeContent = function( node ) {
		return node.value.toLowerCase().trim();
	};

	/**
	 * Is the content a docblock.
	 *
	 * @author Aubrey Portwood <aubrey@webdevstudios.com>
	 * @since  1.2.0
	 *
	 * @param  {String}  content The content.
	 * @return {Boolean}         True if it is, false if not.
	 */
	wdscsUtils.isDocblock = function( content ) {
		return -1 !== content.indexOf( '\n' );
	};

	/**
	 * Does docblock content have a tag?
	 *
	 * @author Aubrey Portwood <aubrey@webdevstudios.com>
	 * @since  1.2.0
	 *
	 * @param  {String} tag     The tag, e.g. @author, @since.
	 * @param  {String} content The content of the docblock.
	 * @return {Mixed}          True if it does, false if not, -1 if not a docblock.
	 */
	wdscsUtils.docBlockContentHasTag = function( tag, content ) {
		if ( wdscsUtils.isDocblock( content ) ) {

			// If we don't have an @author in the content.
			if ( -1 === content.indexOf( '@author' ) ) {

				// Does not have an @author.
				return false;
			}

			return true;
		}

		// Not a docblock (but, technically, true).
		return -1;
	};

	/**
	 * Is a node a file docblock?
	 *
	 * @author Aubrey Portwood <aubrey@webdevstudios.com>
	 * @since  2.2.0
	 *
	 * @param  {Object} node Node Object.
	 * @return {Mixed}       True if it is, false if not, -1 if not a docblock.
	 */
	wdscsUtils.docBlockIsFileDocBlock = function( node ) {
		if ( wdscsUtils.isDocblock( wdscsUtils.getNodeContent( node ) ) ) {

			// If on the first line of the file.
			if ( 0 === node.range[0] ) {

				// This docblock starts at the beginning of the file, e.g. line 0, must be file docblock.
				return true;
			}

			// Docblock, but not on first line.
			return false;
		}

		// Not a docblock.
		return -1;
	};

	/**
	 * Require a docblock on node.
	 *
	 * @author Aubrey Portwood <aubrey@webdevstudios.com>
	 * @since  2.2.0
	 *
	 * @param  {Object} context Context Object.
	 * @param  {Object} node    Node Object.
	 * @param  {string} tag     The tag, e.g. @since, @author.
	 */
	wdscsUtils.docBlockRequireTag = function( context, node, tag ) {

		// Get the node of the associated docblock.
		var docBlockNode = context.getJSDocComment( node );

		// We have a docblock.
		if ( docBlockNode ) {

			// Warn about missing @author tag.
			if ( false === wdscsUtils.docBlockContentHasTag( tag, wdscsUtils.getNodeContent( docBlockNode ) ) ) {

				// Report the message for that tag.
				context.report( docBlockNode, wdscsUtils.messages.requiredTags[ tag ] );
			}
		}
	};

	/**
	 * Require a docblock tag on node type.
	 *
	 * @author Aubrey Portwood <aubrey@webdevstudios.com>
	 * @since  2.2.0
	 *
	 * @param  {Object} context Context Object.
	 * @param  {Object} node    Node Object.
	 * @param  {string} tag     The tag, e.g. @since, @author.
	 * @param  {String} type    The type, e.g. FunctionExpression or *.
	 */
	wdscsUtils.docBlockRequireTagOnType = function( context, node, tag, type ) {
		if ( context.getJSDocComment( node ) ) {

			// If e.g. * or FunctionDeclaration, etc...
			if ( type === node.type ) {

				// Require the tag on this thing.
				wdscsUtils.docBlockRequireTag( context, node, tag );
			}
		}
	};

	// Messages (so we can re-use them).
	wdscsUtils.messages = {
		requiredTags: {
			'@author': 'Documenting @author is helpful. If the author is unknown, you can use @author Unknown.',
			'@since': 'Documenting the version this was introduced is recommended. If you aren\'t using any official versioning standard, consider using the date, e.g.: Friday, October 19, 2018.'
		}
	};

	return wdscsUtils;
} ( {} ) );

/**
 * @see  https://eslint.org/docs/developer-guide/selectors
 */
module.exports = {
	'rules': {

		/**
		 * Require function expressions to need docblock.
		 *
		 * @author Aubrey Portwood <aubrey@webdevstudios.com>
		 * @since  2.2.0
		 */
		'functionExpressionRequireDocblock': {

			/**
			 * Rule Handler.
			 *
			 * @author Aubrey Portwood <aubrey@webdevstudios.com>
			 * @since  2.2.0
			 *
			 * @param  {Object} context Context handler.
			 * @return {Object}         Handler object.
			 */
			create: function( context ) {
				return {

					/**
					 * FunctionExpression Handler.
					 *
					 * @author Aubrey Portwood <aubrey@webdevstudios.com>
					 * @since  2.2.0
					 *
					 * @param  {Object} node Node Object.
					 */
					'FunctionExpression': function( node ) {
						if ( 'CallExpression' === node.parent.type ) {

							// Don't run this on ife's or anonymous functions because they're hard to document.
							return;
						}

						if (

							// E.g. $thing = function( a, b ).
							'VariableDeclarator' === node.parent.type ||

							// E.g. thing.thing = function( a, b ).
							'AssignmentExpression' === node.parent.type ||

							// E.g. return function( a, b ).
							'ReturnStatement' === node.parent.type ||

							// E.g. { thing: function( a, b ) }.
							'Property' === node.parent.type
						) {

							// See if there is a docblock.
							var docBlockNode = context.getJSDocComment( node );

							// This assignment has no docblock!
							if ( ! docBlockNode ) {
								context.report( node, 'Adding a docblock to function expressions is helpful to understand any data coming in.' );
							}
						}
					}
				};
			}
		},

		/**
		 * @author
		 *
		 * As in PHPCS, @author is helpful.
		 *
		 * @author Aubrey Portwood <aubrey@webdevstudios.com>
		 * @since  2.2.0
		 */
		'@author': {

			/**
			 * Rule Handler.
			 *
			 * @author Aubrey Portwood <aubrey@webdevstudios.com>
			 * @since  2.2.0
			 *
			 * @param  {Object} context Context handler.
			 * @return {Object}         Handler object.
			 */
			create: function( context ) {
				return {

					/**
					 * On Every Node Handler.
					 *
					 * @author Aubrey Portwood <aubrey@webdevstudios.com>
					 * @since  2.2.0
					 *
					 * @param  {Object} node Node Object.
					 */
					'*': function( node ) {
						wdscsUtils.docBlockRequireTagOnType( context, node, '@author', 'FunctionDeclaration' );
					}
				};
			}
		},

		/*
		 * @since
		 *
		 * As in PHPCS, @since is required on all docblocks.
		 *
		 * @author Aubrey Portwood <aubrey@webdevstudios.com>
		 * @since 2.2.0
		 */
		'@since': {

			/**
			 * Rule Handler.
			 *
			 * @author Aubrey Portwood <aubrey@webdevstudios.com>
			 * @since  2.2.0
			 *
			 * @param  {Object} context Context handler.
			 * @return {Object}         Handler object.
			 */
			create: function( context ) {
				return {

					/**
					 * On Every Node Handler.
					 *
					 * @author Aubrey Portwood <aubrey@webdevstudios.com>
					 * @since  2.2.0
					 *
					 * @param  {Object} node Node Object.
					 */
					'*': function( node ) {
						wdscsUtils.docBlockRequireTag( context, node, '@since' );
					}
				};
			}
		}
	}
};
