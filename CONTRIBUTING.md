When adding any changes, each change must go through the following PR process:

- Branch off the latest release branch in development
- Add your changes to your branch
- Document your changes in `README.md` under the release, and link to your issue or PR
- Submit PR against the release branch (if your PR is not entirely complete, add the `Not Ready` tag and it can be ignored)
- Add the PR to the release milestone
- PR must be tested at least against Sublime, Atom, PHP Storm, and CLI; there are labels for each of these, request this from other users of these editors, or some may volunteer
- Once the PR has been tested in all editors, a complete review from a Senior Developer and a Lead is required, so request those
- Once your PR is approved/reviewed, it can only be merged into `master` by a lead
