<img src="https://wpengine.com/wp-content/uploads/2015/11/Web-Dev-Studios-Logo.png" width="200" alt="WebDevStudios Logo" align="right" />

# WebDevStudios Coding Standards

WebDevStudios in-house linting and coding standards for your favorite editor.

## How to Install

Simply grab a cup of ☕&nbsp; and follow directions [here](https://github.com/WebDevStudios/WDS-Coding-Standards/wiki/Installation).

## Want to Contribute?

Please see [CONTRIBUTING.md](CONTRIBUTING.md).

___________________

# Rules

See these files for information (in doc-blocks) about any rules we've adopted.

- [@since](WebDevStudios/Sniffs/All/RequireSinceSniff.php)
- [@return](WebDevStudios/Sniffs/All/RequireReturnSniff.php)
- [JS Rules](WebDevStudios/.eslintrc.js)
- [Sass Rules](WebDevStudios/.sass-lint.yml)

___________________

# Changelog

## 1.1.1

- `@since` is now a warning #39
- `@since` will not show a warning for files in `wp-content/themes/**` #39

## 1.1.0

- `@return` and `@since` rules are in place [#27](https://github.com/WebDevStudios/WDS-Coding-Standards/pull/27)
- Find VIM PHPCS configuration [here](https://github.com/WebDevStudios/WDS-Coding-Standards/wiki/Installation:-PHPCS-(PHP-Linting)#editor-configuration-vim) [#28](https://github.com/WebDevStudios/WDS-Coding-Standards/pull/28)
- Brings over eslint rules from wd_s and improves them to be more like old jshint rules from WordPress.org coding standards [#10](https://github.com/WebDevStudios/WDS-Coding-Standards/issues/10) [#22](https://github.com/WebDevStudios/WDS-Coding-Standards/pull/22)
- How to vote is clearer in [CONTRIBUTING.md](CONTRIBUTING.md) [#32](https://github.com/WebDevStudios/WDS-Coding-Standards/pull/32)
- Sass linting added [#26](https://github.com/WebDevStudios/WDS-Coding-Standards/pull/26)

This release brings most of WDS up to par with our currently-established coding standards, of which have been missing from our linting thus-far. Props for this release go to [@aubreypwd](http://github.com/aubreypwd), [@gregrickaby](https://github.com/gregrickaby), [@JayWood](https://github.com/JayWood), [@jrfoell](https://github.com/jrfoell), and [@phatsk](https://github.com/phatsk) for all their helpful work!

## 1.0.1

- Changed `WebDevStudios-phpcs` to just `WebDevStudios` for compatibility with namespaces and new sniffs added later [#12](https://github.com/WebDevStudios/WDS-Coding-Standards/pull/12)
- Inclusion of the `WordPress-Docs` ruleset

Note, this release breaks some things. When you update to this version,
you will need to update your coding standard to `WebDevStudios` vs the old
`WebDevStudios-phpcs` which should no longer work.

## 1.0.0

- Initial ruleset based on WordPress-Extra
