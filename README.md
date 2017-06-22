# WDS-Coding-Standards
A repository to house all our linting and coding standards.

## PHP Code Sniffer
The PHP CS ruleset exists under the `/WebDevStudios` folder of the repo, this is so later we can add custom sniffs, and maybe even dependant rulesets.

### Installation
* Clone the repo to your desired location
* Check if you already have `installed_paths` set by running `phpcs --config-show`

__(Example output)__
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
