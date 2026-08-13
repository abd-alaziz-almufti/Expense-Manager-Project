FROM php:8.3-cli

# ============================================================
# 1. تثبيت system dependencies
# ============================================================
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libxml2-dev \
    libonig-dev \
    curl \
    git \
    unzip \
    zip \
    && rm -rf /var/lib/apt/lists/*

# ============================================================
# 2. تثبيت Node.js 22
# ============================================================
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# ============================================================
# 3. تثبيت PHP extensions المطلوبة لـ Laravel + Filament
# ============================================================
RUN docker-php-ext-install \
    intl \
    zip \
    pdo \
    pdo_mysql \
    mbstring \
    bcmath \
    opcache \
    gd

# ============================================================
# 4. تثبيت Composer
# ============================================================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# ============================================================
# 5. نسخ المشروع وتثبيت الاعتماديات
# ============================================================
COPY . .

# تثبيت اعتماديات PHP (production فقط, بدون dev)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# بناء الـ assets
RUN npm install && npm run build

# صلاحيات الكتابة على storage و bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# ============================================================
# 6. بدء التشغيل عند كل deploy (يحدث بعد توفر متغيرات البيئة)
# ============================================================
CMD php artisan storage:link --force 2>/dev/null || true; \
    php artisan migrate --force && \
    php artisan filament:assets && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
