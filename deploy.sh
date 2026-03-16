#!/bin/bash

# === 1️⃣ تحديث السيرفر وتثبيت المتطلبات ===
sudo apt update -y
sudo apt upgrade -y
sudo apt install git unzip curl php8.2 php8.2-cli php8.2-fpm php8.2-mbstring php8.2-xml php8.2-bcmath php8.2-mysql mysql-client composer npm nodejs certbot python3-certbot-nginx -y

# === 2️⃣ إعداد مجلد المشروع ===
cd /var/www/
git clone https://github.com/username/your-project.git
cd your-project

# === 3️⃣ تثبيت الاعتماديات ===
composer install --no-interaction --optimize-autoloader
npm install
npm run build

# === 4️⃣ إعداد Laravel ===
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link

# === 5️⃣ ضبط الصلاحيات ===
sudo chown -R www-data:www-data /var/www/your-project
chmod -R 775 storage bootstrap/cache

# === 6️⃣ إعداد Nginx ===
NGINX_CONF="/etc/nginx/sites-available/your-project"
sudo bash -c "cat > $NGINX_CONF <<EOL
server {
    listen 80;
    server_name your-domain.com;

    root /var/www/your-project/public;
    index index.php index.html;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php\$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
    }
}
EOL"

sudo ln -s /etc/nginx/sites-available/your-project /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx

# === 7️⃣ تفعيل SSL تلقائي ===
sudo certbot --nginx -d your-domain.com --non-interactive --agree-tos -m your-email@example.com

# === 8️⃣ تفعيل Scheduler وQueue ===
(crontab -l 2>/dev/null; echo "* * * * * cd /var/www/your-project && php artisan schedule:run >> /dev/null 2>&1") | crontab -
php artisan queue:work --daemon &

echo "✅ Deployment completed!"
echo "Visit https://your-domain.com"