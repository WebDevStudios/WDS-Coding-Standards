# WebDevStudios Coding Standards

A repository to house WebDevStudios in-house linting and coding standards.

_________________________

# Want to Contribute?

Please see [CONTRIBUTING.md](CONTRIBUTING.md).

________

# Installation

Follow directions [here](https://github.com/WebDevStudios/WDS-Coding-Standards/wiki/Installation)

_______________________

# Changelog

Props for this release go to [@aubreypwd](http://github.com/aubreypwd) [@gregrickaby](https://github.com/gregrickaby) [@JayWood](https://github.com/JayWood) [@phatsk](https://github.com/phatsk)

## 1.1

- Brings over eslint rules from wd_s and improves them to be more like old jshint rules from WordPress.org coding standards [#10](https://github.com/WebDevStudios/WDS-Coding-Standards/issues/10) [#22](https://github.com/WebDevStudios/WDS-Coding-Standards/issues/22)
- Add vim configuration section to `README.md` #28
- How to vote is clearer in [CONTRIBUTING.md](CONTRIBUTING.md) #32
- `@return` and `@since` rules are in place #27
- Sass linting added #26
- Eslinting added #22 #29

## 1.0.1

- Changed `WebDevStudios-phpcs` to just `WebDevStudios` for compatibility with namespaces and new sniffs added later [#12](https://github.com/WebDevStudios/WDS-Coding-Standards/pull/12)
- Inclusion of the `WordPress-Docs` ruleset

Note, this release breaks some things. When you update to this version,
you will need to update your coding standard to `WebDevStudios` vs the old
`WebDevStudios-phpcs` which should no longer work.

## 1.0

- Initial ruleset based on WordPress-Extra
