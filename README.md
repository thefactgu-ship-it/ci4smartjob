# CI4 SmartJob - Job Management System

A comprehensive employment and job seeker management platform built with CodeIgniter 4. Track job applications, manage company profiles, monitor employment records, and handle job queue processing with real-time notifications.

## 🎯 Features

- ✅ **User Management** - Role-based access control (Administrator, Staff)
- ✅ **Job Seeker Registration** - Comprehensive profile and educational background tracking
- ✅ **Company Management** - Company information and profile management
- ✅ **Job Applications** - Application submission and status tracking
- ✅ **Resume Management** - Generate, store, and export resumes as PDF
- ✅ **Employment History** - Track employment records and job history
- ✅ **Queue Management** - Processing queue system for job applications
- ✅ **Email Notifications** - Automated email alerts and confirmations
- ✅ **Real-time Updates** - WebSocket support for live notifications

## 🛠️ Technology Stack

| Component | Technology |
|-----------|-----------|
| **Backend Framework** | CodeIgniter 4 (PHP 8.1+) |
| **Database** | MySQL 5.7+ / MariaDB |
| **PDF Generation** | TCPDF 6.8+ |
| **Real-time Communication** | Ratchet WebSocket |
| **Email Service** | SMTP (Gmail / Custom) |
| **Frontend** | HTML5, CSS3, JavaScript |
| **ORM** | CodeIgniter 4 Model |
| **Deployment** | Railway.app (Nixpacks) |

## 📋 System Requirements

- **PHP** 8.1 or higher
- **MySQL** 5.7+ or MariaDB 10.3+
- **Composer** (PHP dependency manager)
- **Extensions**: OpenSSL, Intl, Mbstring, MySQLi
- **Disk Space**: 500MB minimum
- **RAM**: 512MB minimum

## 🏗️ System Architecture & Workflow
1️⃣ Local Development Setup

```bash
# Clone the repository
git clone https://github.com/yourusername/ci4smartjob.git
cd ci4smartjob

# Install PHP dependencies
composer install

# Copy environment configuration
cp .env.example .env

# Create MySQL database
mysql -u root -p -e "CREATE DATABASE ci4smartjob CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Run database migrations (creates all tables)
php spark migrate --all

# Seed the database with sample data
php spark db:seed DatabaseSeeder

# Start the development server
php spark serve
```

Access the application: `http://localhost:8080`

### 2️⃣ Default Login Credentials

After seeding the database, use these credentials to test the system:

| Role | Username | Password | Purpose |
|------|----------|----------|---------|
| Admin | `admin` | `admin123` | Full system access |
| Staff | `staff` | `staff123` | Limited management access |

⚠️ **IMPORTANT**: Change these credentials in production!

### 3️⃣ Deploy to Railway.app

For production deployment on Railway.app (free tier):

1. Push to GitHub repository
2. Connect GitHub to Railway.app
3. Add MySQL service
4. Set environment variables
5. Railway auto-deploys and runs migrations

See [DEPLOYMENT.md](DEPLOYMENT.md) for detailed step-by-step
│  │  └─ WebSocket Real-time Updates          │              │
│  └──────────────────────────────────────────┘              │
│                                                               │
└─────────────────────────────────────────────────────────────┘
```

### Database Schema

```
┌─────────────────────────────────────────────────────┐
│              CI4 SmartJob Database                  │
├─────────────────────────────────────────────────────┤
│                                                      │
│  Users Layer:                                       │
│  ├─ employee (admin/staff accounts)                │
│                                                      │
│  Job Seeker Layer:                                 │
│  ├─ personal_information (seeker profiles)         │
│  ├─ address (address details)                      │
│  ├─ educations (education levels)                  │
│  └─ job_history (employment history)               │
│                                                      │
│  Employment Layer:                                 │
│  ├─ employment_information (current/past jobs)     │
│  ├─ company (company profiles)                     │
│  └─ company_select (job seekers → companies)       │
│                                                      │
└─────────────────────────────────────────────────────┘
```

### User Workflow

1. **Admin/Staff Login** → Dashboard access
2. **Job Seeker Registration** → Profile creation
3. **Company Setup** → Add companies and job openings
4. **Job Application** → Seekers apply to companies
5. **Queue Processing** → System processes applications
6. **Notifications** → Email alerts to relevant parties
7. **Resume Generation** → PDF export for documents
8. **Employment Records** → Track final placement

## 🚀 Quick Start Guide

### Local Development

```bash
# 1. Clone repository
git clone https://github.com/yourusername/ci4smartjob.git
cd ci4smartjob

# 2. Install dependencies
composer install

# 3. Setup environment
cp .env.example .env

# 4. Create database
mysql -u root -p -e "CREATE DATABASE ci4smartjob CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 5. Run migrations
php spark migrate --all

# 6. Seed database
php spark db:seed DatabaseSeeder

# 7. Start server
php spark serve
```

Then visit: `http://localhost:8080`

**Default Credentials:**
- Username: `admin` | Password: `admin123`
- Username: `staff` | Password: `staff123`

### Deploy to Railway.app

See [DEPLOYMENT.md](DEPLOYMENT.md) for step-by-step Railway deployment instructions.

## 📁 Project Structure

```
ci4smartjob/
├── app/
│   ├── Config/              # Application configuration files
│   │   ├── App.php          # Base URL, environment settings
│   │   ├── Database.php     # Database connection config
│   │   ├── Routes.php       # Application routing rules
│   │   └── ...              # Other config files
│   ├── Controllers/         # Request handlers
│   │   ├── AuthController.php       # Authentication logic
│   │   ├── Home.php                 # Dashboard & main logic
│   │   ├── CompanyController.php    # Company management
│   │   ├── EmployeeController.php   # Admin management
│   │   ├── User.php                 # Job seeker logic
│   │   ├── PdfController.php        # PDF generation
│   │   └── ...
│   ├── Database/
│   │   ├── Migrations/      # 8 database schema files
│   │   └── Seeds/           # 6 data seeder files
│   ├── Models/              # Data access layer
│   │   ├── PersonalInformationModel
│   │   ├── CompanyModel
│   │   ├── EmployeeModel
│   │   └── ...
│   ├── Views/               # HTML templates
│   ├── Helpers/             # Helper functions
│   ├── Libraries/           # Custom libraries
│   └── Filters/             # Route filters/middleware
├── public/                  # Public web root
│   ├── index.php            # Application entry point
│   ├── css/                 # Stylesheets
│   ├── js/                  # JavaScript files
│   ├── img/                 # Images & assets
│   ├── uploads/             # User uploaded files
│   ├── generate_pdf.php     # PDF generation utility
│   └── websocket/           # WebSocket server files
├── system/                  # CodeIgniter 4 framework core
├── tests/                   # Unit & feature tests
├── writable/                # Writable directories
│   ├── cache/               # Application cache
│   ├── debugbar/            # Debug toolbar cache
│   ├── logs/                # Application logs
│   ├── session/             # Session storage
│   └── uploads/             # Temporary uploads
├── vendor/                  # Composer packages
├── .env                     # Environment configuration (local only)
├── .env.example             # Environment template
├── .gitignore               # Git ignore rules
├── composer.json            # PHP dependencies
├── README.md                # This file
├── DEPLOYMENT.md            # Railway deployment guide
├── SETUP_LOCAL.md           # Local development guide
├── QUICK_START.md           # Quick start guide
└── spark                    # CLI command tool
```

## 📊 Database Schema

The application uses 8 interconnected tables:

### Core Tables

| Table | Purpose | Primary Key |
|-------|---------|-------------|
| **employee** | Admin/Staff user accounts | em_id |
| **personal_information** | Job seeker profiles | personal_id |
| **address** | Location information | address_id |
| **educations** | Education levels | education_id |
| **job_history** | Employment history records | id |
| **employment_information** | Current/past employment | id |
| **company** | Company profiles | company_id |
| **company_select** | Job seeker ↔ Company mapping | id |

### Relationships

```
employee (1) ──→ (many) job_history
personal_information (1) ──→ (many) job_history
personal_information (1) ──→ (many) employment_information
personal_information (1) ──→ (1) address
personal_information (1) ──→ (1) educations
company (1) ──→ (many) company_select
personal_information (1) ──→ (many) company_select
```

## 🔌 API Routes & Endpoints

### Authentication
```
GET  /login                           → Display login page
POST /authcontroller/loginauth        → Process login
GET  /logout                          → User logout
```

### Dashboard & Main Features
```
GET  /home/default                    → Dashboard
GET  /home/emtyjob                    → Empty job list
GET  /home/submitResume               → Resume submissions
GET  /home/promote                    → Job promotions
GET  /home/report                     → Reports list
```

### User Management
```
GET  /user/                           → User dashboard
GET  /user/form_test                  → Test form
GET  /user/form_history               → History form
GET  /user/form_part_time             → Part-time form
POST /user/save                       → Save user info
POST /user/save_history               → Save history
POST /user/save_student               → Save student info
GET  /user/status/:id                 → Check user status
GET  /user/get-status/:id             → Get status (AJAX)
```

### Company Management
```
GET  /company/company_list            → View all companies
GET  /company/addCompany              → Add company form
POST /company/saveAdd_company         → Save new company
POST /company/chk_company             → Check company
POST /company/bulkAction              → Bulk operations
GET  /company/summary                 → Company summary
GET  /company/saveSelection           → Save selection
```

### Employee Management (Admin Only)
```
GET  /employeecontroller/create       → Create employee form
POST /employeecontroller/save         → Save employee
GET  /employeecontroller/profile      → View profile
POST /employeecontroller/updateProfile → Update profile
POST /employeecontroller/updatePassword → Change password
GET  /employeecontroller/employee-list → View all employees
GET  /employeecontroller/deleteEmployee/:id → Delete employee
POST /employeecontroller/updateEmployee → Update employee
```

### Document Generation
```
GET  /generate-resume/:id             → Generate PDF resume
GET  /test-email                      → Test email sending
```

## 🔧 Configuration

### Environment Variables (.env)

```env
# Application Environment
CI_ENVIRONMENT = development          # Set to 'production' for live
app.baseURL = http://localhost:8080/  # Change to your domain

# Database Configuration
database.default.hostname = localhost
database.default.database = ci4smartjob
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.port = 3306

# Email Configuration (SMTP)
EMAIL_PROTOCOL = smtp
EMAIL_HOST = smtp.gmail.com
EMAIL_PORT = 587
EMAIL_CRYPTO = tls
EMAIL_USER = your-email@gmail.com     # Your email account
EMAIL_PASS = your-app-password        # Use Gmail App Password
EMAIL_FROM_NAME = SmartJob System
EMAIL_FROM = your-email@gmail.com
```

## 📚 Documentation & Guides

- **[QUICK_START.md](QUICK_START.md)** - 6-step deployment guide to Railway
- **[DEPLOYMENT.md](DEPLOYMENT.md)** - Detailed Railway.app deployment instructions
- **[SETUP_LOCAL.md](SETUP_LOCAL.md)** - Local development environment setup
- **[RAILWAY_SETUP.md](RAILWAY_SETUP.md)** - Railway.app specific configuration
- **[IMPLEMENTATION_CHECKLIST.md](IMPLEMENTATION_CHECKLIST.md)** - Complete implementation details

## 🚀 Deployment

### Local Testing

Before deploying to production, test locally:

```bash
# Run migrations
php spark migrate --all

# Seed sample data
php spark db:seed DatabaseSeeder

# Start dev server
php spark serve

# Test in browser
# http://localhost:8080/login
# Username: admin, Password: admin123
```

### Production Deployment (Railway.app)

The application is configured for Railway.app deployment:

1. **Files included**:
   - `railway.json` - Build configuration
   - `Procfile` - Deployment commands
   - `composer.json` - PHP dependencies

2. **Auto-deployment features**:
   - Automatic composer dependency installation
   - Database migration execution
   - Sample data seeding
   - SSL/HTTPS enabled automatically

3. **Quick deployment**:
   ```bash
   git push origin main  # Railway auto-deploys
   ```

See [DEPLOYMENT.md](DEPLOYMENT.md) for complete deployment guide.

## 🔐 Security Considerations

- ✅ Use environment variables for sensitive data (.env)
- ✅ Change default admin credentials in production
- ✅ Use Gmail App Passwords instead of account password
- ✅ Enable HTTPS (Railway enables automatically)
- ✅ Regularly backup database
- ✅ Keep CodeIgniter framework updated
- ✅ Validate and sanitize all user inputs
- ✅ Use prepared statements for database queries

## 🐛 Troubleshooting

### Issue: Database Connection Error
```
SQLSTATE[HY000] [2002] Connection refused
```
**Solution**: Verify MySQL is running and credentials in .env are correct

### Issue: 404 Errors on Routes
**Solution**: Ensure web server points to `public/` directory. Check `.htaccess` exists

### Issue: Permission Denied Errors
**Solution**: 
```bash
chmod -R 755 writable/
chmod -R 755 public/uploads/
```

### Issue: Migrations Won't Run
**Solution**:
```bash
php spark migrate:status        # Check status
php spark migrate:refresh --seed # Reset and reseed
```

## 📞 Support & Resources

- **CodeIgniter 4 Documentation**: https://codeigniter.com/docs/
- **CodeIgniter 4 Forum**: https://forum.codeigniter.com/
- **PHP Documentation**: https://www.php.net/manual/
- **MySQL Documentation**: https://dev.mysql.com/doc/
- **Railway.app Documentation**: https://docs.railway.app/

## 📄 License

[Specify your license here]

## 👥 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## ✉️ Contact

For questions, issues, or feedback, please open an issue on GitHub.

---

**Build Date**: May 2026
**Framework**: CodeIgniter 4
**PHP Minimum**: 8.1
**Database**: MySQL 5.7+

**Status**: ✅ Ready for Production

You can read the [user guide](https://codeigniter.com/user_guide/)
corresponding to the latest version of the framework.

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Contributing

We welcome contributions from the community.

Please read the [*Contributing to CodeIgniter*](https://github.com/codeigniter4/CodeIgniter4/blob/develop/CONTRIBUTING.md) section in the development repository.

## Server Requirements

PHP version 8.1 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
> - The end of life date for PHP 7.4 was November 28, 2022.
> - The end of life date for PHP 8.0 was November 26, 2023.
> - If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> - The end of life date for PHP 8.1 will be December 31, 2025.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library
