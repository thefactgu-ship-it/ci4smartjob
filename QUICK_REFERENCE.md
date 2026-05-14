# Quick Reference Guide - CI4 SmartJob

## 📚 Documentation Files

| Document | Purpose | For Whom |
|----------|---------|----------|
| **README.md** | Project overview, features, and setup | Everyone |
| **WORKFLOW.md** | Detailed system workflows and data flow | Developers, Technical Leads |
| **QUICK_START.md** | 6-step Railway deployment guide | DevOps, Deployment |
| **DEPLOYMENT.md** | Comprehensive deployment instructions | DevOps Engineers |
| **SETUP_LOCAL.md** | Local development environment | Developers |
| **RAILWAY_SETUP.md** | Railway-specific configuration | DevOps |
| **IMPLEMENTATION_CHECKLIST.md** | Complete implementation details | Project Managers |

---

## 🎯 Key Features at a Glance

```
Job Seekers
├─ Register & Create Profile
├─ Add Education & Employment History
├─ Browse Companies
├─ Submit Job Applications
├─ View Application Status
├─ Generate PDF Resume
└─ Track Employment Records

Administrators
├─ Manage User Accounts
├─ Add & Edit Companies
├─ Review Job Applications (Queue)
├─ Approve/Reject Applications
├─ Update Employment Records
├─ Send Notifications
└─ Generate Reports

System Features
├─ Role-based Access Control
├─ Automated Email Notifications
├─ PDF Document Generation
├─ Real-time Status Updates (WebSocket)
├─ Queue Management
└─ Database Transactions
```

---

## 🔐 Default Credentials

After database seeding:

```
Admin Account:
└─ Username: admin
   Password: admin123
   Role: Full System Access

Staff Account:
└─ Username: staff
   Password: staff123
   Role: Limited Access
```

⚠️ **CHANGE IN PRODUCTION!**

---

## 🗄️ Database Tables

```
8 Core Tables:
├─ employee (2 demo accounts)
├─ personal_information (5 sample seekers)
├─ address (4 sample addresses)
├─ educations (7 education levels)
├─ job_history (employment records)
├─ employment_information (current jobs)
├─ company (5 sample companies)
└─ company_select (application mapping)
```

---

## 🌐 Main Routes

### Public Routes
- `GET /login` - Login page
- `POST /authcontroller/loginauth` - Process login
- `GET /logout` - User logout

### Job Seeker Routes (After Login)
- `GET /user/` - Dashboard
- `GET /home/promote` - Browse job opportunities
- `POST /company/saveSelection` - Apply to job
- `GET /generate-resume/:id` - Download resume as PDF

### Admin Routes (After Login)
- `GET /home/default` - Admin dashboard
- `GET /home/report` - View reports
- `GET /company/company_list` - Manage companies
- `GET /employeecontroller/employee-list` - Manage staff
- `POST /home/updateStatus/:id` - Update application status

---

## ⚙️ Configuration Essentials

### .env File (Local)
```env
CI_ENVIRONMENT=development
app.baseURL=http://localhost:8080/
database.default.hostname=localhost
database.default.database=ci4smartjob
database.default.username=root
database.default.password=
```

### .env File (Production)
```env
CI_ENVIRONMENT=production
app.baseURL=https://your-app-name.railway.app/
```

Railway auto-populates database credentials!

---

## 🚀 Deployment Checklist

- [ ] Push code to GitHub (main branch)
- [ ] Connect GitHub to Railway.app
- [ ] Add MySQL service in Railway
- [ ] Set environment variables:
  - `CI_ENVIRONMENT=production`
  - `app.baseURL=https://your-app-name.railway.app/`
- [ ] Wait for auto-deployment
- [ ] Migrations run automatically
- [ ] Database seeded automatically
- [ ] Test login: admin / admin123
- [ ] Change default passwords
- [ ] Configure email (optional)
- [ ] Monitor logs for errors

---

## 🔍 Troubleshooting Quick Fixes

### Can't login?
```bash
# Check database exists
mysql -u root -p -e "SHOW DATABASES LIKE 'ci4smartjob';"

# Re-run migrations
php spark migrate:refresh --seed

# Check credentials in .env
```

### 404 errors?
```bash
# Check public/ is web root
# Verify .htaccess exists
# Check routes in app/Config/Routes.php
```

### Email not sending?
```
Verify .env has:
├─ EMAIL_HOST=smtp.gmail.com
├─ EMAIL_PORT=587
├─ EMAIL_CRYPTO=tls
├─ EMAIL_USER=valid-email@gmail.com
└─ EMAIL_PASS=app-password (NOT account password)
```

### Permission denied?
```bash
chmod -R 755 writable/
chmod -R 755 public/uploads/
```

---

## 📊 System Architecture Overview

```
┌─────────────────────────────────────┐
│         User Interface              │
│    (Browser / Mobile App)           │
└────────────────┬────────────────────┘
                 │
        ┌────────▼────────┐
        │   HTTP Requests │
        │   (REST API)    │
        └────────┬────────┘
                 │
┌────────────────▼────────────────────┐
│  CodeIgniter 4 Framework            │
│  ├─ Controllers (request handler)   │
│  ├─ Models (data access)            │
│  ├─ Views (response render)         │
│  └─ Config (routing)                │
└────────────────┬────────────────────┘
                 │
┌────────────────▼────────────────────┐
│  MySQL Database                     │
│  ├─ 8 tables                        │
│  ├─ Foreign key constraints         │
│  ├─ Transactions support            │
│  └─ Indexed queries                 │
└─────────────────────────────────────┘
```

---

## 🔄 Data Flow Summary

```
User Input
    ↓
HTTP Request (Controller)
    ↓
Validate & Authenticate
    ↓
Query/Update Database (Model)
    ↓
Render Response (View)
    ↓
HTTP Response
    ↓
User Output (Browser)
    ↓
    ├─ Email Sent (Async)
    ├─ PDF Generated
    ├─ WebSocket Update
    └─ Notification Sent
```

---

## 📈 Key Metrics

| Metric | Value |
|--------|-------|
| **Database Tables** | 8 |
| **Controllers** | 10 |
| **Models** | 8 |
| **Migration Files** | 8 |
| **Seeder Files** | 6 |
| **Sample Users** | 2 |
| **Sample Companies** | 5 |
| **Sample Job Seekers** | 5 |
| **Built-in Routes** | 40+ |
| **PHP Minimum** | 8.1 |
| **MySQL Minimum** | 5.7 |

---

## 🎓 Learning Resources

- **CodeIgniter 4 Docs**: https://codeigniter.com/docs/
- **PHP Manual**: https://www.php.net/manual/
- **MySQL Reference**: https://dev.mysql.com/doc/
- **Railway Docs**: https://docs.railway.app/
- **REST API Best Practices**: https://restfulapi.net/

---

## 💡 Common Tasks

### Add New User (Admin)
1. Login with admin account
2. Go to `/employeecontroller/create`
3. Fill form
4. Submit
5. New user added to database

### Create Job Seeker Profile
1. Login as job seeker
2. Go to `/user/`
3. Fill personal information form
4. Submit
5. Profile saved in `personal_information` table

### Add New Company
1. Login as admin
2. Go to `/company/addCompany`
3. Fill company details
4. Submit
5. New company in database

### Process Applications
1. Login as admin
2. Go to `/home/default` (dashboard)
3. View pending applications in queue
4. Click to review
5. Click approve/reject
6. Status updated, email sent

### Generate Resume PDF
1. Select job seeker
2. Click "Generate Resume"
3. Route: `/generate-resume/:id`
4. PDF downloads automatically

---

## 🔐 Security Checklist

- [ ] Change default admin password
- [ ] Use Gmail App Passwords (not account password)
- [ ] Enable HTTPS (Railway does automatically)
- [ ] Set `CI_ENVIRONMENT=production`
- [ ] Validate all user inputs
- [ ] Use parameterized queries (CodeIgniter does this)
- [ ] Keep framework updated
- [ ] Backup database regularly
- [ ] Monitor application logs
- [ ] Implement rate limiting (optional)

---

## 📞 Support Quick Links

- **Report Bug**: Open GitHub Issue
- **Ask Question**: GitHub Discussions
- **Documentation**: See README.md
- **Deployment Help**: See DEPLOYMENT.md
- **Workflow Details**: See WORKFLOW.md

---

**Version**: 1.0  
**Last Updated**: May 2026  
**Status**: Production Ready ✅
