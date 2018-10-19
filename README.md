# WebDevStudios Coding Standards

WebDevStudios in-house linting and coding standards for your favorite editor.

<a href="https://webdevstudios.com/contact/"><img src="https://webdevstudios.com/wp-content/uploads/2018/04/wds-github-banner.png" alt="WebDevStudios. WordPress for big brands."></a>

## Leadership

- @aubreypwd (Senior Developer)
    + Writes & Integrates coding Standards/Maintains standards
- @gregrickaby (Director of Engineering)
    + High level Approval / Leadership
- @jrfoells (Senior Developer)
    + Future "Journeyman"

## How to Install

Simply grab a cup of ☕&nbsp; and follow directions [here](https://github.com/WebDevStudios/WDS-Coding-Standards/wiki/Installation).

## Want to Contribute?

Please see [CONTRIBUTING.md](CONTRIBUTING.md).

___________________


# Changelog

## NEXT

- WordPress Coding Standards update to v1.1.0 #50 #46
- Docblocks are required on function assignments in JS
- `@author` is suggested in docblocks in both PHP & JS

## 1.1.1

- WDSCS now requires WPCS 0.14.1 #34; props @jrfoell
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
