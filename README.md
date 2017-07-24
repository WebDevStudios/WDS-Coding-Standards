# WDS-Coding-Standards

A repository to house WDS linting and coding standards.

## Want to Contribute?

Please see [CONTRIBUTING.md](CONTRIBUTING.md).

_______________________

# Installation

* Clone the repo to your desired location

## PHPCS (PHP Linting)

* Check if you already have `installed_paths` set by running `phpcs --config-show`

#### Example output

```
$> phpcs --config-show
installed_paths: /home/wpcs
```

### Set your installed standards path(s).

```
phpcs --config-set installed_paths /home/WDS-Coding-Standards/WebDevStudios,/home/wpcs
```

### WordPress Coding Standards

If you already had an installed path, just add that with a comma. Note that
the [WordPress Coding Standards](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards)
should be installed in separately and included in your `installed_paths`. We
simply add WebDevStudios standards in _addition_ to WPCS.

### Confirm your installation is complete

```
$ phpcs -i
The installed coding standards are PSR1, Squiz, MySource, PSR2, Zend, PEAR, PHPCS, WebDevStudios, WordPress-Core, WordPress-VIP, WordPress-Extra, WordPress-Docs and WordPress
```

> Full list of [Configuration Options](https://github.com/squizlabs/PHP_CodeSniffer/wiki/Configuration-Options) over at the PHP_CodeSniffer wiki.

You should, at this point, be able to `phpcs --standard=WebDevStudios` and set
`WebDevStudios` as your standard in your favorite editors.

## ESLint (JavaScript Linting)

ESLint does not have a _default_ configuration file option, so when running `eslint` you need to
specify the config file located in this repo, `eslintrc.js`, e.g.

`eslint --config=~/path/to/WDS-Coding-Standards/WebDevStudios/eslintrc.js file.js`

Also if you are running eslint globally you need to install `eslint-config-wordpress` globally:

`npm install -g eslint-config-wordpress`

### Sublime Linter

The [SublimeLinter-contrib-eslint](https://github.com/roadhump/SublimeLinter-eslint) package
can be configured to use our eslint config file by default using the settings for `eslint` below:

``` json
"linters": {
	"eslint": {
		"@disable": false,
		"args": [
			"--config=/Users/path/to/WebDevStudios/eslintrc.js",
			"--no-eslintrc"
		],
		"excludes": []
	},
},
```

_You may need to disable your old jshint package._

____________________

# Changelog

## 1.1

- Brings over eslint rules from wd_s and improves them to be more like old jshint rules from WordPress.org coding standards [#10](https://github.com/WebDevStudios/WDS-Coding-Standards/issues/10) [#18](https://github.com/WebDevStudios/WDS-Coding-Standards/issues/18)

## 1.0.1

- Changed `WebDevStudios-phpcs` to just `WebDevStudios` for compatibility with namespaces and new sniffs added later [#12](https://github.com/WebDevStudios/WDS-Coding-Standards/pull/12)
- Inclusion of the `WordPress-Docs` ruleset

Note, this release breaks some things. When you update to this version,
you will need to update your coding standard to `WebDevStudios` vs the old
`WebDevStudios-phpcs` which should no longer work.

## 1.0

- Initial ruleset based on WordPress-Extra
