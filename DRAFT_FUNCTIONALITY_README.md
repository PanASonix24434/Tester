# Draft Functionality for Dokumen Permohonan

## Overview
This document explains the new draft functionality added to the `dokumen_permohonan.blade.php` file for storing user submission data in the `status_stock` table.

## Features Added

### 1. Draft Storage
- Users can save their form data as drafts
- Drafts are stored in the `status_stocks` table with `status = 'draft'`
- Auto-save functionality (saves after 3 seconds of inactivity)

### 2. Draft Loading
- Users can load previously saved drafts
- Drafts are retrieved based on `fish_type_id` and `tahun`

### 3. Draft Submission
- Users can submit drafts for approval
- Changes status from `'draft'` to `'submitted'`

## Database Structure

The functionality uses the existing `status_stocks` table with the following key fields:
- `fish_type_id` - Foreign key to fish_types table
- `tahun` - Year of the application
- `fma` - FMA (Fisheries Management Area)
- `bilangan_stok` - Stock quantity
- `dokumen_senarai_stok` - Stock list document
- `dokumen_kelulusan_kpp` - KPP approval document
- `status` - Status of the record ('draft', 'submitted', etc.)

## API Endpoints

### 1. Store Draft
```
POST /semakan_stok/store-draft
```
**Parameters:**
- `tahun` (required) - Year
- `fish_type_id` (required) - Fish type ID
- `fma` (required) - FMA
- `bilangan_stok` (required) - Stock quantity
- `dokumen_senarai_stok` (optional) - Stock list document file
- `dokumen_kelulusan_kpp` (optional) - KPP approval document file

### 2. Get Draft
```
GET /semakan_stok/get-draft
```
**Parameters:**
- `fish_type_id` (required) - Fish type ID
- `tahun` (required) - Year

### 3. Submit Draft
```
POST /semakan_stok/submit-draft
```
**Parameters:**
- `fish_type_id` (required) - Fish type ID
- `tahun` (required) - Year

## User Interface

The updated `dokumen_permohonan.blade.php` includes:

### Form Fields
- **Jenis Ikan** - Dropdown to select fish type
- **FMA** - Text input for FMA
- **Bilangan Stok** - Number input for stock quantity
- **Dokumen Upload** - File upload fields for documents

### Action Buttons
- **Simpan Draft** - Save current form data as draft
- **Muat Draft** - Load previously saved draft
- **Hantar Permohonan** - Submit draft for approval
- **Muatnaik Dokumen** - Original upload functionality

### Features
- **Auto-save** - Automatically saves draft after 3 seconds of inactivity
- **Success/Error Messages** - Shows feedback messages to users
- **File Upload** - Supports PDF, JPG, JPEG, PNG files up to 2MB
- **Validation** - Client-side and server-side validation

## Usage Instructions

### For Users:
1. Fill in the form fields (Jenis Ikan, FMA, Bilangan Stok)
2. Upload required documents
3. Click "Simpan Draft" to save your work
4. Use "Muat Draft" to load previously saved drafts
5. Click "Hantar Permohonan" when ready to submit

### For Developers:
1. Ensure the database migrations are run
2. Run the FishTypeSeeder to populate fish types:
   ```bash
   php artisan db:seed --class=FishTypeSeeder
   ```
3. The functionality is automatically available in the dokumen_permohonan view

## Error Handling

The system includes comprehensive error handling:
- Validation errors for required fields
- File upload validation
- Database error handling
- User-friendly error messages

## Security Features

- CSRF protection on all forms
- File type validation
- File size limits (2MB max)
- Input sanitization
- Authorization checks

## Future Enhancements

Potential improvements:
- Draft versioning
- Draft comparison
- Bulk draft operations
- Draft expiration
- Email notifications for draft status changes 