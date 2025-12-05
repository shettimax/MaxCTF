# 🚀 External File Server for ABU Portal

A simple Apache-based file server to handle file uploads from the ABU Portal Laravel application via HTTP API.

## 📋 Overview

This external file server provides a RESTful API for:
- **File Uploads**: Handle photos, documents, and Excel files
- **File Retrieval**: Get file URLs and check existence
- **File Management**: Delete files and get metadata
- **Security**: API key authentication and file validation

## 🏗️ Architecture

```
ABU Portal (Laravel) → HTTP API → External File Server (Apache + PHP)
                                    ↓
                              File Storage + CDN
```

## 📁 File Structure

```
external_file_server/
├── upload_handler.php      # Main PHP script handling all API requests
├── apache_config.conf      # Apache virtual host configuration
├── install.sh             # Automated installation script
├── test_upload.php        # Test script to verify installation
└── README.md              # This file
```

## 🚀 Quick Installation

### Option 1: Automated Installation (Recommended)

```bash
# 1. Upload files to your server
scp -r external_file_server/* user@your-server:/tmp/

# 2. SSH into your server
ssh user@your-server

# 3. Run installation script
cd /tmp
chmod +x install.sh
sudo ./install.sh
```

### Option 2: Manual Installation

```bash
# 1. Install required packages
sudo apt update
sudo apt install apache2 php php-curl php-mbstring php-xml php-zip php-gd

# 2. Enable Apache modules
sudo a2enmod rewrite ssl headers

# 3. Create directories
sudo mkdir -p /var/www/html/uploads /var/www/html/logs

# 4. Set permissions
sudo chown -R www-data:www-data /var/www/html/uploads /var/www/html/logs
sudo chmod -R 755 /var/www/html/uploads /var/www/html/logs

# 5. Copy files
sudo cp upload_handler.php /var/www/html/
sudo cp apache_config.conf /etc/apache2/sites-available/external-file-server.conf

# 6. Enable site
sudo a2ensite external-file-server
sudo systemctl restart apache2
```

## ⚙️ Configuration

### 1. Update API Key

Edit `/var/www/html/upload_handler.php`:

```php
$config = [
    'upload_dir' => '/var/www/html/uploads/',
    'max_file_size' => 10 * 1024 * 1024, // 10MB
    'allowed_extensions' => ['jpg', 'jpeg', 'png', 'pdf', 'xlsx', 'xls', 'csv'],
    'api_key' => 'your-secret-api-key-here', // ← Change this!
    'log_file' => '/var/www/html/logs/upload.log'
];
```

### 2. Update Laravel Configuration

In your Laravel `.env` file:

```env
EXTERNAL_FILE_API_URL=https://your-domain.com/api
EXTERNAL_FILE_API_KEY=your-secret-api-key-here
```

### 3. Update Apache Configuration

Edit `/etc/apache2/sites-available/external-file-server.conf`:

```apache
ServerName your-domain.com
ServerAdmin webmaster@your-domain.com
```

## 🔌 API Endpoints

### File Upload
```http
POST /api/upload
Authorization: Bearer your-api-key
Content-Type: multipart/form-data

file: [binary file]
path: student/photos
options: {"category": "student_photo"}
```

**Response:**
```json
{
    "success": true,
    "id": "file_64a1b2c3d4e5f",
    "url": "https://your-domain.com/uploads/student/photos/1234567890_abc123.jpg",
    "path": "student/photos/1234567890_abc123.jpg",
    "size": 1024000,
    "mime_type": "image/jpeg"
}
```

### Check File Exists
```http
GET /api/file/exists?path=student/photos/1234567890_abc123.jpg
Authorization: Bearer your-api-key
```

**Response:**
```json
{
    "exists": true
}
```

### Get File URL
```http
GET /api/file/url?path=student/photos/1234567890_abc123.jpg
Authorization: Bearer your-api-key
```

**Response:**
```json
{
    "url": "https://your-domain.com/uploads/student/photos/1234567890_abc123.jpg"
}
```

### Delete File
```http
DELETE /api/file/delete
Authorization: Bearer your-api-key
Content-Type: application/x-www-form-urlencoded

path=student/photos/1234567890_abc123.jpg
```

**Response:**
```json
{
    "success": true,
    "message": "File deleted successfully"
}
```

### Get File Metadata
```http
GET /api/file/metadata?path=student/photos/1234567890_abc123.jpg
Authorization: Bearer your-api-key
```

**Response:**
```json
{
    "size": 1024000,
    "mime_type": "image/jpeg",
    "created_at": "2024-01-01T12:00:00+00:00",
    "modified_at": "2024-01-01T12:00:00+00:00",
    "permissions": "0644"
}
```

## 🧪 Testing

### 1. Test Installation

```bash
# Upload test script to your server
scp test_upload.php user@your-server:/var/www/html/

# SSH into server and run test
ssh user@your-server
cd /var/www/html
php test_upload.php
```

### 2. Manual Testing with cURL

```bash
# Test file upload
curl -X POST \
  -F "file=@test.txt" \
  -F "path=test" \
  -H "Authorization: Bearer your-api-key" \
  https://your-domain.com/api/upload

# Test file existence
curl -X GET \
  -H "Authorization: Bearer your-api-key" \
  "https://your-domain.com/api/file/exists?path=test/test.txt"
```

## 📊 File Organization

The server organizes files in this structure:

```
/var/www/html/uploads/
├── student/
│   ├── photos/          # Student photos
│   ├── signatures/      # Student signatures
│   └── documents/       # Student documents
├── candidate/
│   ├── photos/          # Candidate photos
│   └── documents/       # Candidate documents
├── excel/
│   ├── student_uploads/ # Student Excel files
│   └── transfer_student_uploads/ # Transfer student files
└── payslips/            # Staff payslips
```

## 🔒 Security Features

- **API Key Authentication**: Bearer token required for all operations
- **File Type Validation**: Only allowed extensions accepted
- **File Size Limits**: Configurable maximum file sizes
- **Directory Traversal Protection**: Secure path handling
- **CORS Configuration**: Configurable cross-origin settings
- **Security Headers**: XSS protection, content type sniffing prevention

## 📝 Logging

### Upload Logs
Location: `/var/www/html/logs/upload.log`

```
[2024-01-01 12:00:00] [INFO] File uploaded successfully: student/photos -> /var/www/html/uploads/student/photos/1234567890_abc123.jpg (Size: 1024000 bytes, External ID: file_64a1b2c3d4e5f)
[2024-01-01 12:01:00] [ERROR] Failed to move uploaded file: /tmp/phpABC123 -> /var/www/html/uploads/student/photos/photo.jpg
```

### Apache Logs
- Access: `/var/log/apache2/external_file_access.log`
- Error: `/var/log/apache2/external_file_error.log`

## 🚨 Troubleshooting

### Common Issues

1. **Permission Denied**
   ```bash
   sudo chown -R www-data:www-data /var/www/html/uploads
   sudo chmod -R 755 /var/www/html/uploads
   ```

2. **Apache Not Starting**
   ```bash
   sudo apache2ctl configtest
   sudo journalctl -u apache2
   ```

3. **File Upload Fails**
   - Check PHP upload limits in `/etc/php/8.x/apache2/php.ini`
   - Verify directory permissions
   - Check upload log files

4. **SSL Certificate Issues**
   ```bash
   sudo certbot --apache -d your-domain.com
   ```

### Debug Mode

Enable debug mode in `upload_handler.php`:

```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## 📈 Performance Optimization

### 1. Enable Compression
```apache
# In Apache config
LoadModule deflate_module modules/mod_deflate.so
<Location />
    SetOutputFilter DEFLATE
</Location>
```

### 2. Enable Caching
```apache
# Cache static files
<FilesMatch "\.(jpg|jpeg|png|gif|pdf)$">
    ExpiresActive On
    ExpiresDefault "access plus 1 month"
</FilesMatch>
```

### 3. CDN Integration
Configure your CDN to cache files from `/uploads/` directory.

## 🔄 Maintenance

### Regular Tasks

1. **Log Rotation**
   ```bash
   # Add to /etc/logrotate.d/apache2
   /var/www/html/logs/*.log {
       daily
       missingok
       rotate 30
       compress
       notifempty
       create 644 www-data www-data
   }
   ```

2. **Disk Space Monitoring**
   ```bash
   # Check upload directory size
   du -sh /var/www/html/uploads/
   
   # Find large files
   find /var/www/html/uploads/ -type f -size +10M
   ```

3. **Backup Strategy**
   ```bash
   # Daily backup script
   tar -czf /backup/uploads-$(date +%Y%m%d).tar.gz /var/www/html/uploads/
   ```

## 📚 Additional Resources

- [Apache Documentation](https://httpd.apache.org/docs/)
- [PHP File Upload Handling](https://www.php.net/manual/en/features.file-upload.php)
- [Laravel HTTP Client](https://laravel.com/docs/http-client)
- [Security Best Practices](https://owasp.org/www-project-top-ten/)

## 🤝 Support

For issues or questions:

1. Check the logs first
2. Verify configuration settings
3. Test with the provided test script
4. Review Apache error logs

---

**Status**: ✅ **Ready for Production**

Your external file server is now ready to handle file uploads from the ABU Portal Laravel application! 
