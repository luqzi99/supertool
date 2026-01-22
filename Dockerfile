# ================================
# Base Image
# ================================
FROM php:8.3-fpm

# ================================
# Install System Dependencies
# ================================
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    nginx \
    nodejs \
    npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install pdo mbstring exif pcntl bcmath gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# ================================
# Install Composer
# ================================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ================================
# Set Working Directory
# ================================
WORKDIR /var/www

# ================================
# Copy Project Files
# ================================
COPY . .

# ================================
# Install PHP Dependencies
# ================================
RUN composer install --no-dev --optimize-autoloader

# ================================
# Build Frontend Assets (Tailwind / Vite)
# ================================
RUN npm install && npm run build

# ================================
# Permissions
# ================================
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache

# ================================
# Nginx Config
# ================================
COPY docker/nginx.conf /etc/nginx/nginx.conf

# ================================
# Expose Port
# ================================
EXPOSE 80

# ================================
# Start Services
# ================================
CMD service nginx start && php-fpm
