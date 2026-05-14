# CI4 SmartJob - Job Management System

ระบบจัดการงาน สำหรับบันทึกสถานะการว่างงานและการจ้างงาน (CI4 SmartJob Platform)

## 🎯 Features

- ✅ **User Management** - ระบบจัดการผู้ใช้งาน (Administrator, Staff)
- ✅ **Job Seeker Registration** - ลงทะเบียนผู้ว่างงาน
- ✅ **Company Management** - จัดการข้อมูลบริษัท
- ✅ **Job Applications** - สมัครงานและติดตามสถานะ
- ✅ **Resume Management** - สร้างและจัดการเรซูเม่ (PDF Export)
- ✅ **Employment History** - บันทึกประวัติการจ้างงาน
- ✅ **Queue Management** - ระบบคิว สำหรับการจัดการอาร์หารการประมวลผล
- ✅ **Email Notifications** - การแจ้งเตือนผ่าน Email
- ✅ **WebSocket Support** - Real-time communication (Ratchet)

## 🛠️ Technology Stack

| Component | Technology |
|-----------|-----------|
| **Framework** | CodeIgniter 4 |
| **Database** | MySQL/MariaDB |
| **PHP Version** | 8.1+ |
| **PDF Generation** | TCPDF |
| **WebSocket** | Ratchet (cboden/ratchet) |
| **Email** | SMTP (Gmail/Custom) |
| **Frontend** | HTML5, CSS3, JavaScript |

## 📋 Requirements

- PHP 8.1 or higher
- MySQL 5.7+ or MariaDB
- Composer
- OpenSSL extension
- Intl extension
- Mbstring extension

## 🚀 Quick Start

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
│   ├── Config/              # Configuration files
│   ├── Controllers/         # Application controllers
│   ├── Database/
│   │   ├── Migrations/      # Database schema migrations
│   │   └── Seeds/           # Database seeders
│   ├── Models/              # Data models
│   └── Views/               # View templates
├── public/                  # Public web root
│   ├── css/                 # Stylesheets
│   ├── js/                  # JavaScript files
│   ├── img/                 # Images
│   └── uploads/             # User uploaded files
├── writable/                # Writable directories (logs, cache, sessions)
├── system/                  # CodeIgniter system files
├── tests/                   # Unit/feature tests
└── README.md
```

## 📖 Documentation

- **[SETUP_LOCAL.md](SETUP_LOCAL.md)** - Local development setup guide
- **[DEPLOYMENT.md](DEPLOYMENT.md)** - Railway.app deployment guide
- **[CodeIgniter 4 Docs](https://codeigniter.com/docs/)** - Framework documentation

## 🚀 Installation

More information about the plans for version 4 can be found in [CodeIgniter 4](https://forum.codeigniter.com/forumdisplay.php?fid=28) on the forums.

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
