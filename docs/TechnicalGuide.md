# Msomi Clan Management System - Technical Guide

## 1. Requirements
- PHP 8.2+
- MySQL 8.0+
- Composer
- Node.js & NPM

## 2. Installation
1. Clone the repository.
2. Run `composer install` and `npm install`.
3. Copy `.env.example` to `.env` and configure database/mail settings.
4. Run `php artisan key:generate`.
5. Run `php artisan migrate --seed`.

## 3. Deployment
- **Web Server**: Nginx or Apache with PHP-FPM.
- **Storage**: Ensure `storage` and `bootstrap/cache` are writable.
- **Symlink**: Run `php artisan storage:link` to enable profile photo and media uploads.

## 4. Performance Tuning
- Database indexes have been added to core tables for optimized searching.
- Use `php artisan config:cache` and `php artisan route:cache` in production.

## 5. Backup & Recovery
- **Database**: Perform daily MySQL dumps: `mysqldump -u [user] -p [db_name] > backup.sql`.
- **Files**: Back up the `storage/app/public` directory which contains all uploaded photos and videos.

---
*Technical Documentation - Msomi Clan System*
