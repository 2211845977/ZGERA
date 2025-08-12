# إعدادات البيئة - StudyGate Users Management

## ملف .env

قم بنسخ محتوى هذا الملف إلى ملف `.env` في مجلد المشروع:

```env
APP_NAME=StudyGate
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=studygate
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

## إعداد قاعدة البيانات

### 1. إنشاء قاعدة البيانات

```sql
CREATE DATABASE studygate CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. إعدادات قاعدة البيانات

تأكد من تحديث الإعدادات التالية في ملف `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=studygate
DB_USERNAME=root
DB_PASSWORD=your_password_here
```

### 3. تشغيل النظام

```bash
# إنشاء مفتاح التطبيق
php artisan key:generate

# تشغيل الـ migrations
php artisan migrate

# إضافة البيانات التجريبية
php artisan db:seed

# أو استخدام الأمر المخصص
php artisan users:setup

# تشغيل الخادم المحلي
php artisan serve
```

## متطلبات النظام

### PHP
- PHP >= 8.1
- PHP Extensions:
  - BCMath PHP Extension
  - Ctype PHP Extension
  - cURL PHP Extension
  - DOM PHP Extension
  - Fileinfo PHP Extension
  - JSON PHP Extension
  - Mbstring PHP Extension
  - OpenSSL PHP Extension
  - PCRE PHP Extension
  - PDO PHP Extension
  - Tokenizer PHP Extension
  - XML PHP Extension

### قاعدة البيانات
- MySQL >= 5.7 أو MariaDB >= 10.2

### Composer
- Composer >= 2.0

## استكشاف الأخطاء

### مشاكل قاعدة البيانات

1. **خطأ في الاتصال بقاعدة البيانات**:
   - تأكد من تشغيل خدمة MySQL
   - تحقق من صحة بيانات الاتصال في ملف `.env`
   - تأكد من وجود قاعدة البيانات `studygate`

2. **خطأ في الـ migrations**:
   ```bash
   php artisan migrate:status
   php artisan migrate:rollback
   php artisan migrate
   ```

### مشاكل التطبيق

1. **خطأ في مفتاح التطبيق**:
   ```bash
   php artisan key:generate
   ```

2. **مشاكل في الكاش**:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

3. **مشاكل في الصلاحيات**:
   ```bash
   chmod -R 755 storage/
   chmod -R 755 bootstrap/cache/
   ```

## الأمان

### إعدادات الإنتاج

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_PASSWORD=strong_password_here
```

### حماية إضافية

1. **تغيير كلمات المرور الافتراضية**:
   - قم بتغيير كلمات المرور في `database/seeders/UserSeeder.php`
   - أو قم بتغييرها من خلال واجهة إدارة المستخدمين

2. **إعداد HTTPS**:
   - تأكد من استخدام HTTPS في الإنتاج
   - قم بتحديث `APP_URL` ليشمل `https://`

3. **مراقبة السجلات**:
   - راجع سجلات الأخطاء في `storage/logs/`
   - راقب سجلات قاعدة البيانات

## الدعم

إذا واجهت أي مشاكل:

1. راجع ملف `USERS_MANAGEMENT_README.md`
2. تحقق من سجلات الأخطاء
3. تأكد من إعدادات البيئة
4. تحقق من متطلبات النظام 