# Local Development Setup

This guide explains how to set up CI4 SmartJob for local development

## 📋 Requirements

- PHP 8.1 or higher
- MySQL 5.7+ or MariaDB
- Composer
- Git
- Web Server (Apache/Nginx) or use PHP built-in server

## 🔧 Installation Steps

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/ci4smartjob.git
cd ci4smartjob
```

### 2. Install PHP Dependencies

```bash
composer install
```

This will:
- Install CodeIgniter 4 framework
- Install required packages (TCPDF, Ratchet, Laminas, etc.)
- Generate autoloader

### 3. Setup Environment File

```bash
cp .env.example .env
```

Edit `.env` and configure:

```
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = ci4smartjob
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
```

### 4. Create Database

#### Using MySQL CLI:

```bash
mysql -u root -p -e "CREATE DATABASE ci4smartjob CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

#### Or using MySQL Workbench:
1. Connect to your MySQL server
2. Create new database: `ci4smartjob`
3. Set charset: `utf8mb4`
4. Set collation: `utf8mb4_unicode_ci`

### 5. Run Database Migrations

Create all tables:

```bash
php spark migrate --all
```

You should see:
```
Migrating: 2024-01-01-000000_CreateEmployeeTable
Migrating: 2024-01-01-000100_CreateEducationsTable
Migrating: 2024-01-01-000200_CreateAddressTable
Migrating: 2024-01-01-000300_CreatePersonalInformationTable
Migrating: 2024-01-01-000400_CreateJobHistoryTable
Migrating: 2024-01-01-000500_CreateEmploymentInformationTable
Migrating: 2024-01-01-000600_CreateCompanyTable
Migrating: 2024-01-01-000700_CreateCompanySelectTable
Seed tables [y/n]: y (if prompted)
```

### 6. Seed the Database (Optional)

Load sample data for testing:

```bash
php spark db:seed DatabaseSeeder
```

This will populate:
- **Employee**: Admin & Staff accounts
- **Education**: Education levels
- **Address**: Sample addresses
- **Company**: 5 sample companies
- **Personal Information**: 5 sample job seekers

### 7. Start Development Server

Using PHP built-in server:

```bash
php spark serve
```

Then open: `http://localhost:8080`

**Or** configure your web server (Apache/Nginx) to point to the `public/` directory.

## 🔐 Test Login Credentials

After seeding, use these to test:

| Role | Username | Password |
|------|----------|----------|
| Admin | `admin` | `admin123` |
| Staff | `staff` | `staff123` |

## 🗂️ Directory Structure

```
ci4smartjob/
├── app/
│   ├── Config/              # Configuration
│   ├── Controllers/         # Request handlers
│   ├── Database/
│   │   ├── Migrations/      # Schema definitions
│   │   └── Seeds/           # Sample data loaders
│   ├── Models/              # Data access layer
│   ├── Views/               # HTML templates
│   ├── Helpers/             # Helper functions
│   └── Libraries/           # Custom libraries
├── public/                  # Web root (CSS, JS, images)
├── system/                  # CodeIgniter core
├── tests/                   # Unit/feature tests
├── writable/                # Logs, cache, sessions
│   ├── cache/
│   ├── debugbar/
│   ├── logs/
│   └── session/
├── vendor/                  # Composer packages
├── .env                     # Environment config (NOT in git)
├── .env.example             # Environment template
├── composer.json            # PHP dependencies
└── spark                    # CLI command tool
```

## 🔄 Useful Commands

```bash
# Start development server
php spark serve

# Run migrations
php spark migrate --all

# Seed database
php spark db:seed DatabaseSeeder

# Reset migrations (⚠️ deletes all tables)
php spark migrate:refresh

# Create new migration file
php spark make:migration create_table_name

# Create new controller
php spark make:controller ControllerName

# Create new model
php spark make:model ModelName

# Run tests
php spark test

# Clear cache
php spark cache:clear

# View help
php spark --help
```

## 🐛 Common Issues

### Issue: "Connection refused" database error

**Solution:**
1. Verify MySQL is running
2. Check credentials in `.env`
3. Test connection: `mysql -h localhost -u root -p ci4smartjob`

### Issue: "File not found" 404 errors

**Solution:**
1. Ensure web server points to `public/` directory
2. Check `.htaccess` exists in `public/` (for Apache)
3. Verify routes in [app/Config/Routes.php](../app/Config/Routes.php)

### Issue: "Permission denied" writable directory

**Solution:**
```bash
chmod -R 755 writable/
```

### Issue: Migrations won't run

**Solution:**
```bash
# Check migration status
php spark migrate:status

# Check specific migration
php spark migrate:rollback

# Try fresh migration
php spark migrate:refresh --seed
```

## 📝 Development Workflow

1. **Create a feature branch:**
   ```bash
   git checkout -b feature/my-feature
   ```

2. **Make changes and test locally**

3. **Commit changes:**
   ```bash
   git add .
   git commit -m "Add: description of changes"
   ```

4. **Push to GitHub:**
   ```bash
   git push origin feature/my-feature
   ```

5. **Create Pull Request on GitHub**

## 🔗 External Tools

### Database GUI Tools

- **MySQL Workbench** - Official MySQL tool
- **phpMyAdmin** - Web-based MySQL management
- **TablePlus** - Modern database client
- **DBeaver** - Universal database tool

### API Testing

- **Postman** - API development and testing
- **Insomnia** - REST client
- **Thunder Client** - VS Code extension

## 📚 Learning Resources

- [CodeIgniter 4 Documentation](https://codeigniter.com/docs/)
- [PHP Documentation](https://www.php.net/manual/)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [MDN Web Docs](https://developer.mozilla.org/) - For HTML/CSS/JavaScript

## 🤝 Contributing

1. Fork the repository
2. Create feature branch: `git checkout -b feature/feature-name`
3. Commit changes: `git commit -am 'Add feature'`
4. Push to branch: `git push origin feature/feature-name`
5. Submit Pull Request

## ❓ Need Help?

- Check [README.md](../README.md) for overview
- See [DEPLOYMENT.md](DEPLOYMENT.md) for Railway deployment
- Open GitHub Issue for bugs/questions
- Check CodeIgniter docs for framework-specific questions

---

**Happy coding! 💻**
