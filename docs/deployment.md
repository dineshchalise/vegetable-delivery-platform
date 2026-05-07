# Ubuntu Deployment Guide

1. Install PHP 8.2 FPM, MySQL 8.0, Redis, Nginx, Composer, Node.js, and Supervisor.
2. Clone the repository to `/var/www/vegetable-delivery`.
3. Run `composer install --no-dev --optimize-autoloader` and `npm ci && npm run build`.
4. Copy `.env.example` to `.env` and set production database, Redis, URL, and SMS values.
5. Run `php artisan key:generate`, `php artisan migrate --seed`, and `php artisan storage:link`.
6. Point Nginx to `public/index.php` and enable SSL using LetEncrypt.
7. Add Supervisor worker:

```ini
[program:vegetable-delivery-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/vegetable-delivery/artisan queue:work redis --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/vegetable-delivery/storage/logs/worker.log
```

8. Add cron:

```cron
* * * * * cd /var/www/vegetable-delivery && php artisan schedule:run >> /dev/null 2>&1
```

9. Schedule daily backups for MySQL and `storage/app/public`. Review security updates weekly and Laravel version upgrades quarterly.
