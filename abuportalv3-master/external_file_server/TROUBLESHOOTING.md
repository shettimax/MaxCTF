# 🔧 External File Server - 404 Error Troubleshooting Guide

## Quick Fixes for 404 Errors

### 1. **Check File Placement**
Ensure your files are in the correct locations:
```bash
# Files should be placed as:
/var/www/html/upload_handler.php
/var/www/uploads/ (upload directory)
/etc/apache2/sites-available/external-file-server.conf
```

### 2. **Test Direct Access First**
Before testing API endpoints, check if the handler responds directly:

```bash
# Test direct access to upload_handler.php
curl http://your-domain.com/upload_handler.php

# Expected response:
{
  "status": "online",
  "server": "External File Server",
  "version": "1.0",
  "endpoints": {...}
}
```

### 3. **Enable Apache Rewrite Module**
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### 4. **Check Apache Site Configuration**
```bash
# Enable your site
sudo a2ensite external-file-server

# Disable default site (optional)
sudo a2dissite 000-default

# Test configuration
sudo apache2ctl configtest

# Restart Apache
sudo systemctl restart apache2
```

### 5. **Verify Directory Permissions**
```bash
sudo chown -R www-data:www-data /var/www/html
sudo chown -R www-data:www-data /var/www/uploads
sudo chmod -R 755 /var/www/html
sudo chmod -R 755 /var/www/uploads
```

## Step-by-Step Diagnostic Process

### Step 1: Check Apache Status
```bash
sudo systemctl status apache2
# Should show "active (running)"
```

### Step 2: Check Apache Error Logs
```bash
sudo tail -f /var/log/apache2/error.log
# Look for any PHP or rewrite errors
```

### Step 3: Test PHP Processing
Create a test PHP file:
```bash
echo "<?php phpinfo(); ?>" | sudo tee /var/www/html/info.php
```
Then visit: `http://your-domain.com/info.php`

### Step 4: Test URL Rewriting
Check if mod_rewrite is working:
```bash
# Check if rewrite module is enabled
apache2ctl -M | grep rewrite
# Should show: rewrite_module (shared)
```

### Step 5: Test API Endpoints Step by Step

1. **Test Status Endpoint**
```bash
curl -v http://your-domain.com/api/status
```

2. **Test with Different Methods**
```bash
# If /api/status gives 404, try:
curl -v http://your-domain.com/upload_handler.php?endpoint=status
```

3. **Test Upload Endpoint**
```bash
# Create a test file first
echo "test content" > test.txt

# Test upload
curl -X POST \
  -F "file=@test.txt" \
  -F "path=test" \
  -H "Authorization: Bearer eyJ1c2VyX2lkIjoiMTIzNDUiLCJyb2xlIjoiYWRtaW4iLCJpYXQiOjE3MjM4OTY4MDAsImV4cCI6MTcyMzk4MzIwMH0." \
  http://your-domain.com/api/upload
```

## Common Issues and Solutions

### Issue 1: "File not found" (404)
**Cause**: Apache can't find upload_handler.php
**Solution**:
```bash
# Ensure file exists and has correct permissions
ls -la /var/www/html/upload_handler.php
sudo chmod 644 /var/www/html/upload_handler.php
```

### Issue 2: "Internal Server Error" (500)
**Cause**: PHP syntax error or missing directories
**Solution**:
```bash
# Check PHP syntax
php -l /var/www/html/upload_handler.php

# Create missing directories
sudo mkdir -p /var/www/uploads /var/www/html/logs
sudo chown www-data:www-data /var/www/uploads /var/www/html/logs
```

### Issue 3: Rewrite Rules Not Working
**Cause**: mod_rewrite disabled or .htaccess issues
**Solution**:
```bash
# Enable mod_rewrite
sudo a2enmod rewrite

# Check virtual host configuration
sudo apache2ctl -S

# Test rewrite rules
curl -v http://your-domain.com/api/status
```

### Issue 4: "Permission Denied"
**Cause**: Incorrect file/directory permissions
**Solution**:
```bash
sudo chown -R www-data:www-data /var/www/
sudo chmod -R 755 /var/www/html
sudo chmod -R 755 /var/www/uploads
```

### Issue 5: PHP Not Processing
**Cause**: PHP module not enabled
**Solution**:
```bash
# Check PHP modules
sudo a2enmod php8.1  # or your PHP version
sudo systemctl restart apache2
```

## Advanced Debugging

### Enable Debug Mode
Add to the top of upload_handler.php:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', '/var/www/html/logs/php_error.log');
```

### Check Apache Configuration
```bash
# Dump all virtual host configurations
sudo apache2ctl -S

# Test configuration syntax
sudo apache2ctl configtest
```

### Monitor Real-time Logs
```bash
# Monitor multiple logs simultaneously
sudo tail -f /var/log/apache2/error.log /var/log/apache2/access.log /var/www/html/logs/upload.log
```

## Alternative Setup (If Above Doesn't Work)

If you're still getting 404 errors, try this simplified setup:

### Option 1: Direct PHP Access
Access the handler directly without URL rewriting:
```
http://your-domain.com/upload_handler.php?endpoint=upload
```

### Option 2: Simple .htaccess Setup
Create `/var/www/html/.htaccess`:
```apache
RewriteEngine On
RewriteRule ^api/upload/?$ upload_handler.php [L,QSA]
RewriteRule ^api/file/(.*)$ upload_handler.php [L,QSA]
RewriteRule ^api/status/?$ upload_handler.php [L,QSA]
```

### Option 3: Subdirectory Setup
Create `/var/www/html/api/` directory and place files there:
```bash
sudo mkdir -p /var/www/html/api
sudo cp upload_handler.php /var/www/html/api/index.php
```

Then access via: `http://your-domain.com/api/`

## Testing Checklist

- [ ] Apache is running (`sudo systemctl status apache2`)
- [ ] PHP is processing (`http://your-domain.com/info.php` works)
- [ ] upload_handler.php exists and is readable
- [ ] mod_rewrite is enabled (`apache2ctl -M | grep rewrite`)
- [ ] Virtual host is enabled (`sudo a2ensite external-file-server`)
- [ ] No Apache configuration errors (`sudo apache2ctl configtest`)
- [ ] Directories exist and have correct permissions
- [ ] No errors in Apache logs

## Support Commands

```bash
# Quick diagnostic
sudo apache2ctl -S
sudo apache2ctl configtest
php -l /var/www/html/upload_handler.php
curl -v http://your-domain.com/upload_handler.php

# Check permissions
ls -la /var/www/html/upload_handler.php
ls -la /var/www/uploads/

# Check Apache modules
apache2ctl -M | grep -E "(rewrite|php)"
```

Run these commands and check the output for any errors. The most common cause of 404 errors is incorrect file placement or disabled URL rewriting.
