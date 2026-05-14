# Railway Deployment - Step by Step Guide

## Prerequisites
- GitHub account (https://github.com) - CREATE ONE IF YOU DON'T HAVE
- Railway account (https://railway.app) - FREE - SIGN UP HERE
- Git installed on your computer
- All code committed locally

---

## 🔧 Step 1: Initialize Git & Commit All Changes

Open terminal/PowerShell in your project folder:

```bash
cd c:\laragon\www\ci4smartjob
```

Initialize git repository:
```bash
git init
```

Add all files:
```bash
git add .
```

Commit with message:
```bash
git commit -m "Initial commit: CI4 SmartJob with migrations, seeders, and Railway config"
```

Verify commit:
```bash
git log
```

**Status Check**: ✅ Code is now tracked by git locally

---

## 🌐 Step 2: Create GitHub Repository (MANUAL STEP)

### What to do:

1. Go to **https://github.com**
2. Click **"+"** icon (top right) → **"New repository"**
3. Fill in:
   ```
   Repository name: ci4smartjob
   Description: Job Management System - CI4 SmartJob Platform
   Public: ✅ YES (important for demo & visibility)
   Initialize repository: ❌ NO (we have files already)
   ```
4. Click **"Create repository"**

### After creating:

GitHub will show you commands like:
```bash
git remote add origin https://github.com/YOUR_USERNAME/ci4smartjob.git
git branch -M main
git push -u origin main
```

**COPY THESE COMMANDS** - we'll use them next!

---

## 📤 Step 3: Connect Local Git to GitHub

Use the commands GitHub gave you:

```bash
# Replace YOUR_USERNAME with your actual GitHub username
git remote add origin https://github.com/YOUR_USERNAME/ci4smartjob.git

# Rename default branch to 'main'
git branch -M main

# Push your code to GitHub
git push -u origin main
```

**Watch for**:
- GitHub might ask for credentials (login with your GitHub account)
- Takes 1-2 minutes to upload all files
- After push, your code is on GitHub! ✅

**Verify**: Visit https://github.com/YOUR_USERNAME/ci4smartjob - should see all files

---

## 🚀 Step 4: Create Railway Account & Connect to GitHub

### Create Railway Account:

1. Go to **https://railway.app**
2. Click **"Start Building"** or **"Sign Up"**
3. Use GitHub to sign up (click "Continue with GitHub")
4. Grant Railway permission to access GitHub
5. You're in! 🎉

### Connect GitHub to Railway:

1. Click **"Create New Project"** (button on Railway dashboard)
2. Select **"Deploy from GitHub"** option
3. You'll see list of your GitHub repositories
4. **Click on `ci4smartjob`** to connect
5. Railway will show deploy preview
6. Click **"Deploy"** to start build

**Status**: Railway is now building your app!

---

## 🗄️ Step 5: Add MySQL Database Service

After initial deployment:

1. In Railway **Project Dashboard**, look for your deployed app
2. Click **"+ Add Service"** button (or "Add")
3. Select **"MySQL"** from the list
4. Railway automatically:
   - Creates MySQL database
   - Sets up credentials
   - Adds environment variables
   - Connects to your app

**This is automatic!** No configuration needed. ✅

---

## ⚙️ Step 6: Set Environment Variables

Railway should auto-populate database variables. Set these manually:

1. Click on your **PHP service** in Railway dashboard
2. Go to **"Variables"** tab
3. Add or update these variables:

```
CI_ENVIRONMENT = production
app.baseURL = https://your-app-name.railway.app/
```

Where `your-app-name` is your Railway app name (found on dashboard).

Optional (for email, if you want):
```
EMAIL_PROTOCOL = smtp
EMAIL_HOST = smtp.gmail.com
EMAIL_PORT = 587
EMAIL_CRYPTO = tls
EMAIL_USER = your-email@gmail.com
EMAIL_PASS = your-app-password
EMAIL_FROM_NAME = SmartJob System
EMAIL_FROM = your-email@gmail.com
```

**Save variables** ✅

---

## 🎯 Step 7: Railway Auto-Deploy Magic

Railway will now:

1. ✅ Install PHP dependencies (composer install)
2. ✅ Run database migrations (php spark migrate --all)
3. ✅ Seed sample data (php spark db:seed DatabaseSeeder)
4. ✅ Generate tables in MySQL
5. ✅ Make app live!

**Watch the logs** (click "Deployments" tab to see progress)

Deployment takes: **3-5 minutes**

---

## ✅ Step 8: Test Your Live App

After deployment completes:

1. Railway shows your app URL (e.g., `ci4smartjob-prod.railway.app`)
2. **Click the URL** to open your app
3. You should see: **"Welcome to CI4 SmartJob"** or login page
4. Login with credentials:
   ```
   Username: admin
   Password: admin123
   ```
5. If you can login → **🎉 SUCCESS!**

---

## 🐛 Troubleshooting Deploy Failures

### Issue: Build Failed
**Check**: Click "Deployments" → View build logs
- Look for error messages
- Usually: missing dependency or config issue
- See [DEPLOYMENT.md](../DEPLOYMENT.md) for common issues

### Issue: Database Connection Error
**Check**: 
- MySQL service exists (click "Services" tab)
- Environment variables are set
- Wait 2 minutes for services to connect

### Issue: 404 Error on App
**Check**:
- App is running (green status in Railway)
- Visit correct URL from Railway dashboard
- Check logs for PHP errors

### Issue: Can't Login
**Check**:
- Database seeding completed
- Check Railway logs for seeding errors
- Try accessing: `/home/default` instead

---

## 📊 What Happens Behind the Scenes

```
Your GitHub Push
        ↓
Railway Detects Change
        ↓
Starts Build Process
        ↓
├─ composer install (get dependencies)
├─ composer post-install-cmd (run migrations)
├─ Database tables created
├─ Sample data inserted (seeders)
└─ App deployed to live server
        ↓
MySQL Service Connected
        ↓
App is LIVE! 🌍
```

---

## 🔐 Post-Deployment Security

**Important - Do this IMMEDIATELY:**

1. **Change admin password**
   - Login as admin
   - Go to profile settings
   - Change password from "admin123" to something secure
   - Save

2. **Change staff password**
   - Login as staff
   - Change password from "staff123" to something secure

3. **Configure email (optional)**
   - Set real email credentials in Railway variables
   - Test with `/test-email` route

4. **Verify HTTPS**
   - Your app URL should be `https://` (not http://)
   - Railway enables this automatically ✅

---

## 📈 Monitor Your Deployment

After going live:

1. **Check Logs**: Railway → Deployments → View logs
2. **Monitor Performance**: Railway → Metrics tab
3. **Track Activity**: Application logs in `writable/logs/`
4. **Database Backups**: Railway provides backup options

---

## 🎉 Success Indicators

Your deployment is successful if:

✅ App loads at Railway URL  
✅ Login page displays  
✅ Can login with admin/admin123  
✅ Dashboard shows  
✅ Database has sample data  
✅ Can navigate to different pages  
✅ No 500 errors in logs  
✅ Email service working (if configured)  

---

## 📋 Quick Command Reference

```bash
# Git operations
git init                    # Initialize repo
git add .                   # Stage all files
git commit -m "message"     # Commit changes
git push origin main        # Push to GitHub

# CodeIgniter commands (for local testing)
php spark serve             # Run local server
php spark migrate --all     # Run migrations
php spark db:seed           # Seed database
```

---

## 📞 Need Help?

| Issue | Resources |
|-------|-----------|
| Git problems | https://git-scm.com/doc |
| GitHub help | https://docs.github.com/ |
| Railway docs | https://docs.railway.app/ |
| CodeIgniter | https://codeigniter.com/docs/ |
| MySQL | https://dev.mysql.com/doc/ |

---

## 🎯 Next Steps After Deployment

1. ✅ Verify app works
2. ✅ Change admin passwords
3. ✅ Test all features (job applications, PDF, etc.)
4. ✅ Configure email if needed
5. ✅ Share URL with your team
6. ✅ Start using the platform!

---

**Deployment Checklist**: Follow steps 1-8 above

**Estimated Time**: 30-45 minutes total

**Result**: Your app live on the internet! 🌍

Let me know when you complete each step!
