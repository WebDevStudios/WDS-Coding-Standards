# Developing WDSCS

In order to develop on WDSCS, you will have to run your PHPCS ruleset off a clone of the repo. Trying to develop off `~/.composer/*` proves problematic.

1. Clone the repo
2. Run `composer install`
2. Make sure your `phpcs --config-set installed_paths` is set to something like:

```bash
phpcs --config-set installed_paths "/Users/aubreypwd/Repos/WDS-Coding-Standards/vendor/wp-coding-standards/wpcs,/Users/aubreypwd/Repos/WDS-Coding-Standards"
```

_Note, if you have any other standards installed, make sure they are appended to the above. Use `phpcs --config-show` to find out what those are._

Now your coding standards will be running off of the development version. Note, you can always checkout stable versions easily via `git checkout x.x`.

`phpcs -i` should yield something like:

```bash
$ phpcs -i
The installed coding standards are PEAR, Zend, PSR2, MySource, Squiz, PSR1, WordPress-VIP, WordPress, WordPress-Extra, WordPress-Docs, WordPress-Core and WebDevStudios
```
_________________

# Changes

When adding __any__ changes, each change must go through the following PR process:

- Branch off the latest release branch in development, e.g. `release-x.x`
- Add your changes
- Document your changes in `README.md` under the release changelog, and link to your issue or PR
- Submit PR against the release branch (if your PR is not entirely complete, add the `Not Ready` label and it will be ignored until you remove it)
- Add the PR to the release milestone too
- PR must be tested at least against Sublime, Atom, PHP Storm, and CLI; there are labels for each of these and must have them all (request this from other users of these editors, or some may volunteer)
- Once the PR has been tested in all editors, a complete review from a Senior Developer and a Lead is required (Add the `Lead/Senior Review Needed` label so we can notice those, remove this label when the two reviews are done)
- Once your PR has the correct number of votes, and is fully reviewed, it can only be merged into `master` by a lead (add the `Ready For Lead Merge` label when it's ready for this, or the lead can just merge it right in)

# Upstream Updates

When an update is made to the [WordPress-Coding-Standard](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/releases), it needs to be reviewed by WDS and then if approved, included in our [composer.json](https://github.com/WebDevStudios/WDS-Coding-Standards/blob/master/composer.json) file, and then a new release tagged.

Once a new release is tagged, all WDS developers need to update their local WDS-Coding-Standards per the [composer installation instructions](https://github.com/WebDevStudios/WDS-Coding-Standards/wiki/Installation#composer).

# Additional Approval of New Rules

Changes that introduce new rules require at least 5 votes/blessings. Two of them
must be from a lead. Once a new rule has these 5 votes, add the `Approved Rule`
label and it can be merged in immediately if it's been tested in the above
editors.

## How to vote

Voting is as simple as going to [Pull Requests](https://github.com/WebDevStudios/WDS-Coding-Standards/pulls) and filtering for PRs that ["Needs Votes"](https://github.com/WebDevStudios/WDS-Coding-Standards/pulls?q=is%3Aopen+is%3Apr+label%3A%22Needs+Votes%22)

Then scroll to the bottom of the conversation and give a 👍 or 👎. If you're giving a dissenting vote, please explain why you do not approve of this change so that we can fix it or at least come to a consensus that this does not meet WebDevStudio's standards of excellence.

![wds-coding-standards-voting](https://user-images.githubusercontent.com/630830/31842232-ac59d226-b5b2-11e7-882c-bcff69fdcc31.gif)
