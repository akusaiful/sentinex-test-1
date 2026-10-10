# Rules for AI coding agents in this repository

These rules apply to interactive OpenCode sessions (web / @CodeBot) on the factory server.

1. Never commit to the default branch. Work on `ai/<short-topic>`; if asked to continue an
   existing branch, `git fetch origin && git checkout <branch> && git pull --rebase` first.
2. Do not edit `.env*`, `composer.json/lock`, `package*.json`, `phpunit.xml*`, `.github/`,
   or existing tests unless the user explicitly asks in this session.
3. Add tests for new behaviour. Run `php artisan test` and `vendor/bin/pint <changed files>`
   before every push. Do not push with failing tests.
4. Push and open a PR: `git push -u origin HEAD` then
   `gh pr create --fill --base <default-branch>`. Reply with the PR URL.
5. The PR gets a preview at `https://pr-<N>-<project>.dev.<domain>` — mention it.
6. Never print, copy or commit secrets. Never run destructive commands outside this repo.
