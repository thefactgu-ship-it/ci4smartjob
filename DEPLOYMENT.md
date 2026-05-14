# Deployment Guide - Railway.app

This guide explains how to deploy CI4 SmartJob to Railway.app

## 📋 Prerequisites

- GitHub account with the project repository
- Railway.app account (sign up at [railway.app](https://railway.app))
- Git installed locally

## 🚀 Step-by-Step Deployment

### 1. Prepare Your GitHub Repository

Ensure your repository has been pushed with all recent changes:

```bash
git add .
git commit -m "Prepare for Railway deployment"
git push origin main
```

**Important**: Verify that `.gitignore` excludes:
- `.env` (use `.env.example` as template)
- `vendor/` directory
- `writable/uploads/`, `writable/cache/`, `writable/logs/`, `writable/session/`

### 2. Create Railway Project

1. Go to [railway.app](https://railway.app)
2. Click **"New Project"**
3. Select **"Deploy from GitHub"**
4. Authorize Railway to access your GitHub account
5. Select the `ci4smartjob` repository
6. Click **"Deploy"**

### 3. Add MySQL Database

Railway will detect your project as a PHP application. Now add MySQL:

1. In Railway dashboard, click **"+ Add"**
2. Select **"Add Service"**
3. Choose **"MySQL"**
4. Railway automatically creates a MySQL database

### 4. Configure Environment Variables

Railway will auto-populate database credentials. Set these variables in the Railway dashboard:

#### Required Variables

```
CI_ENVIRONMENT=production
app.baseURL=https://your-app-name.railway.app/

# Database - Usually auto-populated by Railway
# database.default.hostname=
# database.default.database=
# database.default.username=
# database.default.password=
# database.default.port=3306
```

#### Optional Variables (Email)

```
EMAIL_PROTOCOL=smtp
EMAIL_HOST=smtp.gmail.com
EMAIL_PORT=587
EMAIL_CRYPTO=tls
EMAIL_USER=your-email@gmail.com
EMAIL_PASS=your-app-password
EMAIL_FROM_NAME=SmartJob System
EMAIL_FROM=your-email@gmail.com
```

**Note**: Use [Gmail App Passwords](https://support.google.com/accounts/answer/185833) instead of your regular Gmail password.

### 5. Configure Railway Settings

In the Railway dashboard for your PHP service:

1. Click on the PHP service
2. Go to **"Settings"** tab
3. Set **Public Path** to `public`
4. Set **Start Command** to empty (Railway auto-detects PHP)

### 6. Add Build & Start Scripts

Railway should auto-detect `composer.json` and run `composer install`. 

To run migrations and seeders automatically on deploy:

1. Create a file: `railway.json` in project root:

```json
{
  "build": {
    "builder": "dockerfile"
  }
}
```

**OR** create a `Procfile` (simpler):

```
web: vendor/bin/php-server -t public -S 0.0.0.0:$PORT
release: php spark migrate --all && php spark db:seed DatabaseSeeder
```

Then commit:
```bash
git add Procfile railway.json
git commit -m "Add Railway config"
git push origin main
```

### 7. Deploy

1. Railway should automatically start deployment
2. Watch the build logs in the Railway dashboard
3. Once build completes, your app is live!

### 8. Verify Deployment

1. Railway provides a public URL (e.g., `your-app-name.railway.app`)
2. Visit your app URL
3. Login with default credentials:
   - **Username**: `admin`
   - **Password**: `admin123`

## 🔄 Automatic Migrations on Deploy

To ensure migrations run automatically on each deploy, create a `composer.json` post-install script:

Add to `composer.json` in the `scripts` section:

```json
{
  "scripts": {
    "post-install-cmd": [
      "php spark migrate --all",
      "php spark db:seed DatabaseSeeder"
    ]
  }
}
```

## 🗄️ Database Management

### Connect to Remote Database

Using MySQL CLI:

```bash
mysql -h DATABASE_HOST -u DATABASE_USER -p DATABASE_NAME
```

Get credentials from Railway dashboard (MySQL service → "Data" tab).

### View Database in Railway

1. Click MySQL service in Railway
2. Go to **"Data"** tab
3. View/manage database directly

### Reset Database

To reset the database and reseed:

```bash
# Via Railway CLI
railway run php spark migrate:refresh --seed

# Or manually in Railway terminal
php spark db:seed DatabaseSeeder
```

## 🚨 Troubleshooting

### App Not Deploying

Check build logs:
1. Go to Railway dashboard
2. Click PHP service
3. View **"Build Logs"** and **"Deploy Logs"**

Common issues:
- Missing PHP extensions (check `composer.json` requirements)
- Database connection timeout
- Invalid environment variables

### Database Connection Error

```
SQLSTATE[HY000] [2002] Connection refused
```

Solution:
1. Verify MySQL service is running in Railway
2. Check environment variables are set correctly
3. Ensure database exists (run migrations)

### 404 Errors on Routes

1. Verify `public/` is set as public path in Railway settings
2. Check `.htaccess` file exists in `public/` directory
3. Verify routes in [app/Config/Routes.php](../app/Config/Routes.php)

### File Upload Issues

Ensure `writable/uploads/` is writable:

```bash
# Check via Railway shell
ls -la writable/
```

If permissions are wrong:
```bash
chmod -R 755 writable/
```

## 📊 Monitoring

Railway provides logs and metrics:

1. View **"Logs"** in Railway dashboard for real-time application logs
2. Check **"Metrics"** for CPU, Memory, Network usage
3. View **"Deployments"** history

## 🔐 Security Notes

⚠️ **Important for Production:**

1. **Change Default Credentials**
   - Don't use `admin/admin123` in production
   - Update employee credentials in database

2. **Enable HTTPS**
   - Railway auto-provides SSL/TLS certificates

3. **Hide Debug Toolbar**
   - Set `CI_ENVIRONMENT=production` in Railway

4. **Backup Database**
   - Regularly backup MySQL data
   - Use Railway's backup features if available

## 📝 Logging

Application logs are stored in `writable/logs/`

View logs:
```bash
railway run tail -f writable/logs/log-*.log
```

## 🎯 Next Steps

After successful deployment:

1. ✅ Test all features (login, job applications, PDF generation)
2. ✅ Configure custom domain (optional)
3. ✅ Setup automated backups
4. ✅ Monitor application performance
5. ✅ Plan database optimization for scale

## 📞 Support

For Railway-specific issues, visit:
- [Railway Docs](https://docs.railway.app)
- [Railway Discord Community](https://discord.gg/railway)

For CI4 issues:
- [CodeIgniter 4 Docs](https://codeigniter.com/docs/)
- [GitHub Issues](https://github.com/codeigniter4/CodeIgniter4/issues)

---

**Happy deploying! 🚀**
