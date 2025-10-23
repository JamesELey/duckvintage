# Plesk Deployment Guide for DuckVintage

## Automatic Deployment Configuration

This Laravel application is configured to work automatically on Plesk servers without manual document root configuration.

## What's Included

1. **Root `.htaccess`** - Automatically routes all requests to the `public` folder
2. **Public `.htaccess`** - Standard Laravel rewrite rules for routing

## Deployment Steps

### 1. Upload Files
Upload all project files to your Plesk domain's root directory (e.g., `/httpdocs/` or `/var/www/vhosts/yourdomain.com/httpdocs/`)

### 2. Set Permissions
Ensure the following directories are writable:
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### 3. Install Dependencies
If Plesk has SSH access:
```bash
composer install --optimize-autoloader --no-dev
```

### 4. Configure Environment
1. Copy `.env.example` to `.env`
2. Update the following in `.env`:
   ```
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://www.duckvintage.com
   
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   ```

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Run Migrations
```bash
php artisan migrate --force
```

### 7. Link Storage
```bash
php artisan storage:link
```

### 8. Optimize for Production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Plesk-Specific Settings

### Apache & nginx Directives (Optional)
If you want to set the document root to `public` folder directly in Plesk:

1. Go to **Websites & Domains** > Your domain > **Hosting Settings**
2. Change **Document root** to: `/public`
3. Save changes

This is optional - the root `.htaccess` file handles routing automatically.

### PHP Settings
Recommended PHP settings in Plesk:
- **PHP Version**: 8.1 or higher
- **PHP Handler**: FPM application served by Apache

Required PHP Extensions:
- BCMath
- Ctype
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML

## Troubleshooting

### 404 Errors on Routes
1. Verify `.htaccess` files are uploaded
2. Ensure Apache `mod_rewrite` is enabled
3. Check that `AllowOverride All` is set in Apache configuration

### Checking in Plesk
1. Go to **Apache & nginx Settings**
2. Add to **Additional directives for HTTP**:
   ```
   <Directory /var/www/vhosts/yourdomain.com/httpdocs>
       AllowOverride All
   </Directory>
   ```

### Permission Errors
```bash
chown -R username:psacln storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

Replace `username` with your system user (check with `whoami`)

## Git Deployment

If using Git in Plesk:
1. Add to `.gitignore` (if not already):
   ```
   /node_modules
   /public/hot
   /public/storage
   /storage/*.key
   /vendor
   .env
   .phpunit.result.cache
   ```

2. After each pull:
   ```bash
   composer install --optimize-autoloader --no-dev
   php artisan migrate --force
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

## Security Notes

1. Ensure `.env` file is never publicly accessible
2. Set `APP_DEBUG=false` in production
3. Keep Laravel and dependencies updated
4. Use HTTPS (Plesk Let's Encrypt SSL recommended)

## Support

For issues specific to your Plesk configuration, contact your hosting provider.

