/**
 * Custom WDS ESLint Rules.
 *
 * In order for this to work you need to:
 *
 *     npm install -g /path/to/eslint-plugin-webdevstudios
 */

/* globals module */

/**
 * Custom functions.
 */
var wdscs = ( function( wdscs ) {

	/**
	 * Get the content of a node.
	 *
	 * @author Aubrey Portwood <aubrey@webdevstudios.com>
	 * @since  Friday, October 19, 2018
	 *
	 * @param  {Object} node The node.
	 * @return {String}      The content of the node.
	 */
	wdscs.getNodeContent = function( node ) {
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
	wdscs.isDocblock = function( content ) {
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
	wdscs.docBlockContentHasTag = function( tag, content ) {
		if ( wdscs.isDocblock( content ) ) {

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

	wdscs.docBlockIsFileDocBlock = function( node ) {
		if ( wdscs.isDocblock( wdscs.getNodeContent( node ) ) ) {

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

	wdscs.docBlockRequireTagOn = function( context, node, tag, type ) {
		if ( context.getJSDocComment( node ) ) {

			// If e.g. a function something() {...
			if ( type === node.type ) {

				// Get the node of the associated docblock.
				var docBlockNode = context.getJSDocComment( node );

				// We have a docblock.
				if ( docBlockNode ) {

					// Warn about missing @author tag.
					if ( false === wdscs.docBlockContentHasTag( tag, wdscs.getNodeContent( docBlockNode ) ) ) {

						// Report the message for that tag.
						context.report( docBlockNode, wdscs.messages.requiredTags[ tag ] );
					}
				}
			}
		}
	};

	// Messages (so we can re-use them).
	wdscs.messages = {
		requiredTags: {
			'@author': 'Documenting @author is helpful. If the author is unknown, you can use @author Unknown.'
		}
	};

	return wdscs;
} ( {} ) );

module.exports = {
	'rules': {
		'required-tags': {
			create: function( context ) {
				return {

					// On every node in the document.
					'*': function( node ) {
						wdscs.docBlockRequireTagOn( context, node, '@author', 'FunctionDeclaration' );
					}
				};
			}
		}
	}
};
