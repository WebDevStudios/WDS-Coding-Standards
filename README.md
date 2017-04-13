# WDS-Coding-Standards
A repository to house all our linting and coding standards.

## PHP Code Sniffer
The PHP CS ruleset exists under the `/phpcs` folder of the repo, this is so later we can add custom sniffs, and maybe even dependant rulesets.

### Installation
* Clone the repo to your desired location
* Check if you already have `installed_paths` set by running `phpcs --config-show`

__(Example output)__
```
$ phpcs --config-show
installed_paths: /home/wpcs
```

* Copy that path if you have one.
* Set your installed standards path(s).

```
phpcs --config-set installed_paths /home/WDS-Coding_Standards/phpcs
```

If you alread had an installed path, just add that with a comma

```
phpcs --config-set installed_paths /home/WDS-Coding_Standards/phpcs,/home/wpcs
```

> Full list of [Configuration Options](https://github.com/squizlabs/PHP_CodeSniffer/wiki/Configuration-Options) over at the PHP_CodeSniffer wiki.
