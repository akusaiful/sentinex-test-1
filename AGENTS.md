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
5. Coolify builds a preview ~1–2 minutes after the PR opens: `https://pr-<PR number>-<repo folder name>.dev.sentinex.my`
   (e.g. PR #6 in `sentinex-test-1` → https://pr-6-sentinex-test-1.dev.sentinex.my). Give the user that exact
   URL with the real PR number, and say they will get a Telegram message when it is live.
6. Never print, copy or commit secrets. Never run destructive commands outside this repo.
