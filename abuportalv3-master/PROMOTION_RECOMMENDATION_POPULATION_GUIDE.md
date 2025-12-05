# 🚀 Promotion Recommendation Population Guide

## 📋 Overview

This guide explains how to use the new **Promotion Recommendation Population** feature that allows staff to generate promotion recommendation records for specific employees by personnel number and year.

## 🎯 What It Does

The feature calls the `populatePromotionRecomendation` function for a specific employee, which:

1. **Creates/Updates** promotion recommendation records
2. **Populates** employee qualification data
3. **Sets up** publication and supervision records
4. **Initializes** the recommendation workflow
5. **Organizes** data by department, faculty, and complex

## 🔗 Access Path

**Menu Location:** Users → Populate Promotion Recommendation

**Direct Route:** `/users/promotion/recommendation/populate`

## 📝 How to Use

### Step 1: Access the Form

1. Navigate to **Users** in the main menu
2. Click on **Populate Promotion Recommendation**
3. You'll see a form with two required fields

### Step 2: Fill the Form

#### Personnel Number
- **Field:** Personnel Number
- **Required:** Yes
- **Format:** Enter the exact personnel number (e.g., P12345, JP001)
- **Validation:** Must exist in the system and be active

#### Promotion Year
- **Field:** Promotion Year
- **Required:** Yes
- **Options:** Available years from 2020 to current year + 5
- **Format:** Academic year (e.g., 2024/2025)

### Step 3: Submit

1. Click **"Populate Promotion Recommendation"** button
2. System will process the request
3. Success/error messages will be displayed
4. Form will retain input values for reference

## ✅ Success Scenarios

### New Record Created
```
✅ Promotion recommendation for John Doe (PN: P12345) has been successfully created for year 2024.
```

### Existing Record Updated
```
✅ Promotion recommendation for John Doe (PN: P12345) has been successfully updated for year 2024.
```

## ❌ Error Scenarios

### Employee Not Found
```
❌ Employee with this personnel number not found.
```

### Employee Not Active
```
❌ Employee is not active. Status: Inactive
```

### Insufficient Data
```
❌ Unable to retrieve complete employee data. Please ensure employee has all required information.
```

### Permission Denied
```
❌ You have no permission to populate promotion recommendations
```

### Scope Access Denied
```
❌ This employee is not in your scope.
```

## 🔒 Required Permissions

**Permission:** `staff.promotion.recommendation.populate`

**Access Control:**
- User must have the required permission
- User must have scope access to the employee
- Employee must be in an accessible department/faculty

## 📊 What Gets Populated

### Employee Information
- Basic details (ID, personnel number, name, title)
- Dates (first appointment, confirmation, last promotion)
- Current rank and salary step
- Department, faculty, and complex information

### Academic Data
- Highest qualification and course
- Publications (split by type)
- Student supervision count
- Current academic status

### Organizational Structure
- Department name and ID
- Faculty name and ID
- Complex name and ID
- Reporting hierarchy

## 🔍 Recent Activity

The page displays a table showing:
- **Recent promotion recommendations** (last 10)
- **Current status** of each recommendation
- **Last update timestamps**
- **Employee and department information**

### Status Indicators

- **Pending** (Gray) - No recommendations yet
- **Unit Level** (Blue) - HOD recommendation completed
- **Faculty Level** (Yellow) - Dean recommendation completed
- **Completed** (Green) - All levels completed

## 🚨 Important Notes

### Data Requirements
- Employee must exist in the system
- Employee must have complete profile information
- Employee must be assigned to a department and faculty
- Employee must have current rank and salary information

### System Behavior
- **New records** are created if none exist for the year
- **Existing records** are updated with current information
- **Batch processing** handles large datasets efficiently
- **Error logging** captures all issues for debugging

### Best Practices
1. **Verify employee data** before populating
2. **Use correct personnel numbers** (case-sensitive)
3. **Select appropriate years** for promotion exercises
4. **Check permissions** before attempting population
5. **Monitor logs** for any system issues

## 🔧 Technical Details

### Controller Method
```php
public function populatePromotionRecommendation(Request $request)
```

### Model Method Called
```php
PromotionRecomendation::populatePromotionRecomendation($staffCollection, $year)
```

### Database Operations
- **Upsert operation** (insert or update)
- **Batch processing** (1000 records at a time)
- **Transaction safety** with error handling
- **Audit logging** for all operations

### File Locations
- **Controller:** `app/Http/Controllers/UserController.php`
- **View:** `resources/views/pages/staff/users/promotion_recommendation_form.blade.php`
- **Routes:** `routes/staff.php`
- **Menu:** `app/Models/Menu.php`

## 🧪 Testing

### Test Cases
1. **Valid employee** with complete data
2. **Invalid personnel number**
3. **Inactive employee**
4. **Missing permissions**
5. **Out of scope employee**
6. **Existing recommendation** (should update)

### Test Data
- Use test personnel numbers: `TEST001`, `TEST002`
- Test with different years: `2024`, `2025`
- Verify error handling and success messages

## 📞 Support

### Common Issues
1. **Permission denied** - Check user permissions
2. **Employee not found** - Verify personnel number
3. **Scope access denied** - Check user department access
4. **Data incomplete** - Ensure employee profile is complete

### Debug Information
- Check Laravel logs: `storage/logs/laravel.log`
- Verify database connections
- Check employee data integrity
- Validate permission assignments

---

**Status:** ✅ **Ready for Production**

This feature is now fully integrated into the ABU Portal system and ready for use by authorized staff members. 
