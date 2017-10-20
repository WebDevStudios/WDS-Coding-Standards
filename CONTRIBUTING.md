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

# Additional Approval of New Rules

Changes that introduce new rules require at least 5 votes/blessings. Two of them
must be from a lead. Once a new rule has these 5 votes, add the `Approved Rule`
label and it can be merged in immediately if it's been tested in the above
editors.

Please add a 👍 or 💯 in a comment if you would like to issue your vote.
