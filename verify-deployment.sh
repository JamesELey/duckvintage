#!/bin/bash

# Duck Vintage - Deployment Verification Script
# This script verifies that the deployment was successful

echo "🦆 Duck Vintage - Deployment Verification"
echo "=========================================="
echo ""

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Function to check status
check_status() {
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✓${NC} $1"
        return 0
    else
        echo -e "${RED}✗${NC} $1"
        return 1
    fi
}

# Check if .env file exists
echo "Checking configuration files..."
if [ -f .env ]; then
    check_status ".env file exists"
else
    echo -e "${RED}✗${NC} .env file missing!"
    exit 1
fi

# Check .htaccess files
if [ -f .htaccess ]; then
    check_status "Root .htaccess exists"
else
    echo -e "${RED}✗${NC} Root .htaccess missing!"
fi

if [ -f public/.htaccess ]; then
    check_status "Public .htaccess exists"
else
    echo -e "${RED}✗${NC} Public .htaccess missing!"
fi

if [ -f storage/.htaccess ]; then
    check_status "Storage .htaccess exists"
else
    echo -e "${YELLOW}!${NC} Storage .htaccess missing (optional)"
fi

# Check storage permissions
echo ""
echo "Checking permissions..."
if [ -w storage/logs ]; then
    check_status "Storage directory is writable"
else
    echo -e "${RED}✗${NC} Storage directory not writable!"
fi

if [ -w bootstrap/cache ]; then
    check_status "Bootstrap cache is writable"
else
    echo -e "${RED}✗${NC} Bootstrap cache not writable!"
fi

# Check if vendor directory exists
echo ""
echo "Checking dependencies..."
if [ -d vendor ]; then
    check_status "Vendor directory exists"
else
    echo -e "${RED}✗${NC} Vendor directory missing! Run: composer install"
    exit 1
fi

# Check database connection
echo ""
echo "Checking database connection..."
php artisan migrate:status > /dev/null 2>&1
check_status "Database connection works"

# Check if tables exist
echo ""
echo "Checking database tables..."
php artisan tinker --execute="echo 'Tables: ' . count(DB::select('SHOW TABLES'));" 2>/dev/null | grep -q "Tables:"
check_status "Database tables exist"

# Check if admin user exists
echo ""
echo "Checking seeded data..."
php artisan tinker --execute="echo App\Models\User::where('email', 'admin@duckvintage.com')->exists() ? 'yes' : 'no';" 2>/dev/null | grep -q "yes"
check_status "Admin user exists"

# Check if categories exist
php artisan tinker --execute="echo App\Models\Category::count();" 2>/dev/null | grep -q "[1-9]"
check_status "Categories exist"

# Check if storage is linked
echo ""
echo "Checking storage link..."
if [ -L public/storage ]; then
    check_status "Storage is linked"
else
    echo -e "${YELLOW}!${NC} Storage not linked. Run: php artisan storage:link"
fi

# Check if APP_KEY is set
echo ""
echo "Checking application key..."
grep -q "APP_KEY=base64:" .env
check_status "Application key is set"

# Test artisan commands
echo ""
echo "Testing artisan commands..."
php artisan --version > /dev/null 2>&1
check_status "Artisan is working"

# Check routes are cached (production)
echo ""
echo "Checking cache status..."
if [ -f bootstrap/cache/routes-v7.php ]; then
    check_status "Routes are cached"
else
    echo -e "${YELLOW}!${NC} Routes not cached (run: php artisan route:cache)"
fi

if [ -f bootstrap/cache/config.php ]; then
    check_status "Config is cached"
else
    echo -e "${YELLOW}!${NC} Config not cached (run: php artisan config:cache)"
fi

echo ""
echo "=========================================="
echo -e "${GREEN}Deployment verification complete!${NC}"
echo ""
echo "Next steps:"
echo "1. Visit your website: https://www.duckvintage.com"
echo "2. Login as admin: admin@duckvintage.com / admin123"
echo "3. Check admin panel: https://www.duckvintage.com/admin"
echo "4. Test categories: https://www.duckvintage.com/categories/jeans"
echo ""
echo "If any issues, check logs:"
echo "  tail -f storage/logs/laravel.log"
echo ""

