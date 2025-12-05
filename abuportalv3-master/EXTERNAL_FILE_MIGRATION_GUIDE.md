# 🚀 External File Storage Migration Guide

## 📋 Overview

This guide outlines the migration from local file storage to external HTTP file storage for the ABU Portal v3 application. The migration affects file uploads in the following controllers:

- `StudentPhotoUploadController`
- `CandidatePhotoUploadController` 
- `DocumentsController`
- `StudentDocumentsController`
- `StudentController`

## 🎯 Migration Benefits

- **Scalability**: External storage can handle unlimited file uploads
- **Performance**: CDN integration for faster file delivery
- **Reliability**: Redundant storage with backup options
- **Security**: Centralized access control and virus scanning
- **Cost**: Pay-as-you-use model vs. server storage costs

## 🔧 Prerequisites

### 1. External File Server Setup

You need an external file server with HTTP API endpoints:

```bash
# Required API endpoints
POST /api/upload          # File upload
GET  /api/file/url        # Get file URL
DELETE /api/file/delete    # Delete file
GET  /api/file/exists     # Check file existence
GET  /api/file/metadata   # Get file metadata
```

### 2. Laravel Dependencies

Ensure these packages are installed:

```bash
composer require guzzlehttp/guzzle
composer require intervention/image
```

## ⚙️ Configuration

### 1. Environment Variables

Add these to your `.env` file:

```env
# External File Storage Configuration
EXTERNAL_FILE_API_URL=https://your-external-server.com/api
EXTERNAL_FILE_API_KEY=your-secret-api-key
EXTERNAL_FILE_TIMEOUT=30
EXTERNAL_FILE_RETRY_ATTEMPTS=3

# File Paths
EXTERNAL_FILE_STUDENT_PHOTOS_PATH=student/photos
EXTERNAL_FILE_CANDIDATE_PHOTOS_PATH=candidate/photos
EXTERNAL_FILE_STUDENT_SIGNATURES_PATH=student/signatures
EXTERNAL_FILE_CANDIDATE_DOCUMENTS_PATH=candidate/documents
EXTERNAL_FILE_STUDENT_DOCUMENTS_PATH=student/documents
EXTERNAL_FILE_EXCEL_FILES_PATH=excel

# CDN Configuration (Optional)
EXTERNAL_FILE_CDN_ENABLED=true
EXTERNAL_FILE_CDN_URL=https://cdn.your-domain.com

# Backup Configuration
EXTERNAL_FILE_BACKUP_ENABLED=true
EXTERNAL_FILE_LOCAL_COPY=false
EXTERNAL_FILE_RETENTION_DAYS=30
```

### 2. Configuration Files

The migration includes:

- `config/external-files.php` - External file storage settings
- `config/filesystems.php` - Updated with external disk configuration

## 🔄 Migration Steps

### Phase 1: Service Layer Implementation

1. **ExternalFileService** - Core service for HTTP file operations
2. **Configuration** - Environment and config file setup
3. **Error Handling** - Comprehensive logging and retry mechanisms

### Phase 2: Controller Updates

#### StudentPhotoUploadController
- ✅ Updated to use external file service
- ✅ Image processing and optimization
- ✅ Fallback to local default images
- ✅ Comprehensive error logging

#### CandidatePhotoUploadController
- ✅ Updated to use external file service
- ✅ Image processing and optimization
- ✅ Fallback to local default images
- ✅ Comprehensive error logging

#### DocumentsController
- ✅ Updated to use external file service
- ✅ Support for multiple document types
- ✅ Document deletion functionality
- ✅ Enhanced metadata storage

#### StudentDocumentsController
- ✅ Updated to use external file service
- ✅ Support for multiple document types
- ✅ Document deletion functionality
- ✅ Enhanced metadata storage

#### StudentController
- ✅ Excel file uploads to external server
- ✅ Bulk student processing
- ✅ Transfer student processing
- ✅ Comprehensive logging

### Phase 3: Database Updates

#### New Fields Added

```sql
-- For candidate_documents table
ALTER TABLE candidate_documents 
ADD COLUMN external_id VARCHAR(255) NULL,
ADD COLUMN external_url TEXT NULL,
ADD COLUMN uploaded_at TIMESTAMP NULL;

-- For tracking external file uploads
CREATE TABLE external_file_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    file_path VARCHAR(500) NOT NULL,
    external_id VARCHAR(255) NULL,
    external_url TEXT NULL,
    category VARCHAR(100) NOT NULL,
    uploaded_by BIGINT UNSIGNED NULL,
    file_size BIGINT UNSIGNED NULL,
    mime_type VARCHAR(100) NULL,
    status ENUM('success', 'failed', 'deleted') DEFAULT 'success',
    error_message TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_uploaded_by (uploaded_by),
    INDEX idx_status (status)
);
```

## 🚀 Implementation Details

### 1. File Upload Flow

```php
// Before (Local Storage)
$file->move(public_path('studentpics'), $fileName);

// After (External Storage)
$result = $this->externalFileService->uploadWithRetry($file, $photoPath, [
    'category' => 'student_photo',
    'student_id' => $studentid,
    'original_name' => $file->getClientOriginalName(),
    'size' => $file->getSize()
]);
```

### 2. File Retrieval Flow

```php
// Before (Local Storage)
if (file_exists(public_path() . '/studentpics/' . $studentId . '.JPG')) {
    $url = 'studentpics/' . $studentId . '.JPG';
}

// After (External Storage)
$photoPath = "student/photos/{$studentId}.JPG";
if ($this->externalFileService->exists($photoPath)) {
    $url = $this->externalFileService->getUrl($photoPath);
}
```

### 3. Error Handling

```php
if ($result['success']) {
    Log::info('File uploaded successfully to external server', [
        'path' => $photoPath,
        'external_id' => $result['external_id'],
        'url' => $result['url']
    ]);
} else {
    Log::error('Failed to upload file to external server', [
        'path' => $photoPath,
        'error' => $result['error']
    ]);
}
```

## 🔍 Testing

### 1. Unit Tests

```bash
# Test external file service
php artisan test --filter=ExternalFileServiceTest

# Test updated controllers
php artisan test --filter=StudentPhotoUploadControllerTest
```

### 2. Integration Tests

```bash
# Test file upload endpoints
php artisan test --filter=FileUploadIntegrationTest
```

### 3. Manual Testing

1. **Photo Uploads**: Test student and candidate photo uploads
2. **Document Uploads**: Test various document type uploads
3. **Excel Uploads**: Test bulk data uploads
4. **Error Scenarios**: Test network failures and invalid files

## 📊 Monitoring & Logging

### 1. Log Files

- `storage/logs/external-file-uploads.log` - Upload success/failure logs
- `storage/logs/external-file-errors.log` - Error logs with stack traces

### 2. Metrics to Monitor

- Upload success rate
- File processing time
- External server response time
- Error frequency by type
- Storage usage trends

### 3. Alerts

Set up alerts for:
- Upload failure rate > 5%
- External server response time > 10s
- Storage quota > 80%

## 🔒 Security Considerations

### 1. API Key Management

- Store API keys in environment variables
- Rotate keys regularly
- Use least privilege principle
- Monitor API key usage

### 2. File Validation

- File type validation
- File size limits
- Virus scanning (if supported by external server)
- Content validation

### 3. Access Control

- User authentication required
- Role-based access control
- File ownership validation
- Audit logging

## 🚨 Rollback Plan

### 1. Quick Rollback

```bash
# Revert to local storage
git revert <migration-commit>
php artisan config:clear
php artisan cache:clear
```

### 2. Data Recovery

- External files remain accessible via API
- Database references maintained
- Gradual migration back to local storage possible

## 📈 Performance Optimization

### 1. Batch Operations

- Upload multiple files in single request
- Use connection pooling
- Implement retry with exponential backoff

### 2. Caching

- Cache external file URLs
- Cache file metadata
- Use CDN for static assets

### 3. Async Processing

- Queue large file uploads
- Background image processing
- Non-blocking file operations

## 🔧 Troubleshooting

### Common Issues

1. **Upload Failures**
   - Check API key validity
   - Verify external server connectivity
   - Check file size limits
   - Review error logs

2. **Slow Performance**
   - Optimize image processing
   - Use CDN for file delivery
   - Implement caching
   - Monitor network latency

3. **File Access Issues**
   - Verify file permissions
   - Check external server status
   - Validate file paths
   - Review access logs

### Debug Commands

```bash
# Test external server connectivity
php artisan tinker
app(App\Services\ExternalFileService::class)->exists('test/path');

# Check configuration
php artisan config:show external-files

# View logs
tail -f storage/logs/laravel.log | grep "external"
```

## 📚 Additional Resources

- [Laravel HTTP Client Documentation](https://laravel.com/docs/http-client)
- [Intervention Image Documentation](https://image.intervention.io/)
- [File Storage Best Practices](https://laravel.com/docs/filesystem)
- [API Design Guidelines](https://restfulapi.net/)

## 🤝 Support

For migration support:

1. **Documentation**: Review this guide thoroughly
2. **Testing**: Test in staging environment first
3. **Monitoring**: Monitor logs and performance metrics
4. **Backup**: Maintain backup of local files during transition
5. **Gradual Rollout**: Migrate one controller at a time

---

**Migration Status**: ✅ **COMPLETED**

All specified controllers have been successfully migrated to use external file storage via HTTP API. 
