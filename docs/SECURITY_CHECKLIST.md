# Security Checklist Before Publishing

Use this checklist before pushing the repository to a public GitHub repository.

- Confirm `.env` is not tracked:

```bash
git ls-files .env
```

The command should return no output.

- Search for secrets:

```bash
rg -n "(EMAIL_PASS|api[_-]?key|secret|token|password=|MYSQLPASSWORD|DATABASE_URL)" .
```

- Keep real credentials only in local `.env` or Railway Variables.
- Replace `YOUR_USERNAME` and `your-app-name` placeholders only with public-safe values.
- Uploaded files in `public/uploads/` should stay ignored. Only `default-profile.png` should remain versioned as the fallback profile image.
- Change demo passwords after deployment if the app is exposed publicly.
