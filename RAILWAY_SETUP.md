# Railway.app Configuration Helper

## Setup Instructions for Railway.app

This project is configured to deploy directly to Railway.app with MySQL database support.

### Quick Setup

1. **Connect GitHub Repository to Railway**
   - Go to [railway.app](https://railway.app)
   - Create new project → Deploy from GitHub
   - Select this repository
   - Railway auto-detects PHP application

2. **Add MySQL Service**
   - In Railway dashboard: `+ Add Service`
   - Select `MySQL`
   - Railway creates database automatically

3. **Environment Variables**
   - Railway auto-populates database credentials
   - Set `CI_ENVIRONMENT=production` in Railway dashboard
   - Set `app.baseURL=https://your-app-name.railway.app/`

### Files Included

- **railway.json** - Railway build configuration
- **Procfile** - Deployment commands (migrations & seeders)
- **composer.json** - PHP dependencies
- **.env.example** - Environment template

### Automatic Setup

On first deploy, Railway will:
1. Install PHP dependencies (`composer install`)
2. Run database migrations (`php spark migrate --all`)
3. Seed sample data (`php spark db:seed DatabaseSeeder`)

### Database

- MySQL service created automatically
- Tables created via migrations
- Sample data loaded via seeders
- Connection: Auto-configured by Railway

### First Login

After deployment:
- Visit: `https://your-app-name.railway.app`
- Username: `admin`
- Password: `admin123`

⚠️ **Change default password in production!**

### Support

- [Railway Docs](https://docs.railway.app)
- [CodeIgniter 4 Docs](https://codeigniter.com/docs/)
- Check [DEPLOYMENT.md](../DEPLOYMENT.md) for detailed guide
