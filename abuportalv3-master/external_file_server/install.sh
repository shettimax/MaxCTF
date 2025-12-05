#!/bin/bash

# External File Server Installation Script
# Run this script on your Apache server to set up the file upload system

echo "🚀 Installing External File Server for ABU Portal..."

# Check if running as root
if [ "$EUID" -ne 0 ]; then
    echo "❌ Please run this script as root (use sudo)"
    exit 1
fi

# Update system
echo "📦 Updating system packages..."
apt update && apt upgrade -y

# Install required packages
echo "📦 Installing required packages..."
apt install -y apache2 php php-curl php-mbstring php-xml php-zip php-gd

# Enable required Apache modules
echo "🔧 Enabling Apache modules..."
a2enmod rewrite
a2enmod ssl
a2enmod headers

# Create directories
echo "📁 Creating directories..."
mkdir -p /var/www/html
mkdir -p /var/www/uploads
mkdir -p /var/www/html/logs

# Set permissions
echo "🔐 Setting permissions..."
chown -R www-data:www-data /var/www/uploads
chown -R www-data:www-data /var/www/html/logs
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/uploads
chmod -R 755 /var/www/html/logs
chmod -R 755 /var/www/html

# Copy files
echo "📋 Copying files..."
cp upload_handler.php /var/www/html/
cp apache_config.conf /etc/apache2/sites-available/external-file-server.conf
if [ -f "test_setup.php" ]; then
    cp test_setup.php /var/www/html/
    echo "   ✓ test_setup.php copied"
fi

# Enable site
echo "🌐 Enabling Apache site..."
a2ensite external-file-server

# Disable default site (optional)
read -p "Do you want to disable the default Apache site? (y/n): " disable_default
if [ "$disable_default" = "y" ]; then
    a2dissite 000-default
    echo "✅ Default site disabled"
fi

# Restart Apache
echo "🔄 Restarting Apache..."
systemctl restart apache2

# Check Apache status
echo "🔍 Checking Apache status..."
if systemctl is-active --quiet apache2; then
    echo "✅ Apache is running successfully"
else
    echo "❌ Apache failed to start. Check logs: journalctl -u apache2"
    exit 1
fi

# Create test file
echo "🧪 Creating test file..."
echo "<?php phpinfo(); ?>" > /var/www/html/test.php

# Display configuration
echo ""
echo "🎉 Installation completed successfully!"
echo ""
echo "📋 Configuration Summary:"
echo "   - Upload directory: /var/www/uploads"
echo "   - Log directory: /var/www/html/logs"
echo "   - Upload handler: /var/www/html/upload_handler.php"
echo "   - API endpoints: /api/*"
echo "   - Test file: /test.php"
echo "   - Status endpoint: /api/status"
echo ""
echo "🔧 Next steps:"
echo "   1. Update your Laravel .env file with:"
echo "      EXTERNAL_FILE_API_URL=https://your-domain.com/api"
echo "      EXTERNAL_FILE_API_KEY=your-secret-api-key-here"
echo ""
echo "   2. Update the API key in /var/www/html/upload_handler.php"
echo ""
echo "   3. Test the upload:"
echo "      # Test status endpoint:"
echo "      curl https://your-domain.com/api/status"
echo "      # Test file upload:"
echo "      curl -X POST -F 'file=@test.txt' -F 'path=test' -H 'Authorization: Bearer your-api-key' https://your-domain.com/api/upload"
echo ""
echo "   4. Remove test file: rm /var/www/html/test.php"
echo ""
echo "📚 Logs are available at:"
echo "   - Apache access: /var/log/apache2/external_file_access.log"
echo "   - Apache error: /var/log/apache2/external_file_error.log"
echo "   - Upload log: /var/www/html/logs/upload.log"
echo "   - Test setup: php /var/www/html/test_setup.php"
echo ""
echo "🔒 Security notes:"
echo "   - Change the default API key"
echo "   - Configure SSL certificates for production"
echo "   - Restrict CORS origins if needed"
echo "   - Monitor logs regularly"
