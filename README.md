# WDS-Coding-Standards
A repository to house all our linting and coding standards.

## PHP Code Sniffer

The PHP CS ruleset exists under the `/WebDevStudios` folder of the repo, this is so later we can add custom sniffs, and maybe even dependant rulesets.

### Installation

* Clone the repo to your desired location
* Check if you already have `installed_paths` set by running `phpcs --config-show`

#### Example output

```
$> phpcs --config-show
installed_paths: /home/wpcs
```

* Copy that path if you have one.
* Set your installed standards path(s).

```
phpcs --config-set installed_paths /home/WDS-Coding-Standards/WebDevStudios
```

If you alread had an installed path, just add that with a comma

```
phpcs --config-set installed_paths /home/WDS-Coding_Standards/WebDevStudios,/home/wpcs
```

* Confirm your installation is complete

```
$> phpcs -i
The installed coding standards are PSR1, Squiz, MySource, PSR2, Zend, PEAR, PHPCS, WebDevStudios, WordPress-Core, WordPress-VIP, WordPress-Extra, WordPress-Docs and WordPress
```

> Full list of [Configuration Options](https://github.com/squizlabs/PHP_CodeSniffer/wiki/Configuration-Options) over at the PHP_CodeSniffer wiki.

____________________

# Changelog

## 1.0.1

- Changed `WebDevStudios-phpcs` to just `WebDevStudios` for compatibility with namespaces and new sniffs added later [#12](https://github.com/WebDevStudios/WDS-Coding-Standards/pull/12)
- Inclusion of the `WordPress-Docs` ruleset

Note, this release breaks some things. When you update to this version,
you will need to update your coding standard to `WebDevStudios` vs the old
`WebDevStudios-phpcs` which should no longer work.

## 1.0

- Initial ruleset based on WordPress-Extra
