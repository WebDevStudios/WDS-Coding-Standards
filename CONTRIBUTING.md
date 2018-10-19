# Developing WDSCS or using the Bleeding Edge

In order to develop on WDSCS, you will have to run your PHPCS ruleset off a clone of the repo. Trying to develop off `~/.composer/*` proves problematic.

1. Clone the repo somewhere
2. Run `composer install` in that directory to make sure you have cool source code you can reference e.g. Goto Definition
2. Make sure your `phpcs --config-set installed_paths` is set to something like:

```bash
phpcs --config-set installed_paths "/path/to/WDS-Coding-Standards/vendor/wp-coding-standards/wpcs,/path/to/WDS-Coding-Standards"
```

_Note 1: If you have any other standards installed, make sure they are appended to the above. Use `phpcs --config-show` to find out what those are._
_Note 2: If you are using the composer method, this will essentially disable that as you will be using standards from a new directory._

`phpcs -i` should yield something like:

```bash
$ phpcs -i
The installed coding standards are PEAR, Zend, PSR2, MySource, Squiz, PSR1, WordPress-VIP, WordPress, WordPress-Extra, WordPress-Docs, WordPress-Core and WebDevStudios
```

Now your coding standards will be running off of the development version via the repo you cloned and _it's_ dependencies. Note, you can always checkout stable versions easily via `git checkout x.x` and `rm -Rf vendor/` then `composer install`.

_________________

# Changes

When adding __any__ changes, each change must go through the following PR process:

- Branch off the latest release branch in development, e.g. `release-x.x`
- Add your changes
- Document your changes in `README.md` under the release changelog, and link to your issue or PR
- Submit PR against the release branch (if your PR is not entirely complete, add the `Not Ready` label and it will be ignored until you remove it)
- Ensure your PR merges into the next release
- Please test your PR in editors, and add labels accordingly
- Each PR should have at least one review to get into the release

# Upstream Updates

When an update is made to the [WordPress-Coding-Standard](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/releases), it needs to be reviewed by WDS and then if approved, included in our [composer.json](https://github.com/WebDevStudios/WDS-Coding-Standards/blob/master/composer.json) file, and then a new release tagged.

Once a new release is tagged, all WDS developers need to update their local WDS-Coding-Standards per the [composer installation instructions](https://github.com/WebDevStudios/WDS-Coding-Standards/wiki/Installation#composer).

# Additional Approval of New Rules

All new rules must be documented in README.md and releases require at least a LEAD, BED, and FED review to go into `master`.
