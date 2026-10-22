# justsmartchoice.com deployment

The production website is versioned in `ssmugdho7/justsmartchoice.com`, branch `main`.

- Local checkout: `/Users/mugdho/Documents/ChatGPT/justsmartchoice/justsmartchoice.com`
- Bluehost checkout: `/home2/scusawco/public_html/justsmartchoice.com`
- Live URL: https://justsmartchoice.com

Review and test the intended local changes, commit them, and push `origin/main`. Then connect with:

```sh
ssh -i ~/.ssh/id_ed25519 scusawco@162.144.17.232
cd ~/public_html/justsmartchoice.com
```

Verify the server has no tracked modifications and the release is a fast-forward. Back up the previous tracked source outside `public_html`, then deploy with normal public-file permissions:

```sh
umask 022
git pull --ff-only origin main
git rev-parse HEAD
```

Compare that SHA with the tested local/GitHub commit and verify affected live routes and assets. The installed `justsmartchoice-deploy` Codex skill describes the full checks and backup procedure.

The repository is public. `.gitignore` excludes credentials, embedded-key scripts, host configuration, internal dev-tools, runtime databases, customer/runtime data, uploads, archives, logs, and the separate NewsMail and fdata applications. Keep existing ignored server files in place; a fresh source checkout alone does not provision a working environment. Do not force-add ignored files, force-push, reset/clean production, or overwrite private configuration as part of a normal deployment.
