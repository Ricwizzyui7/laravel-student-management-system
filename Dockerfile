FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents
COPY . /var/www

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# --- FRONTEND BUILD ENVIRONMENT FOR TAILWIND ---
# Download and install Node.js 18
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Force configuration env context to development temporarily so npm links binaries correctly
ENV NODE_ENV=development

# Clear any local node modules cache and install all tools explicitly
RUN rm -rf node_modules package-lock.json \
    && npm install \
    && ./node_modules/.bin/vite build

# Reset environment back to production
ENV NODE_ENV=production
# -----------------------------------------------
# Configure Nginx
COPY ./nginx.conf /etc/nginx/sites-available/default

# Create the view directory if missing and wipe any local cache
RUN mkdir -p /var/www/storage/framework/cache/data \
    && mkdir -p /var/www/storage/framework/app/cache \
    && mkdir -p /var/www/storage/framework/sessions \
    && mkdir -p /var/www/storage/framework/views

# Generate the public storage link folder bridge
RUN php artisan storage:link

# Set strict permissions for www-data user across everything including built assets
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache /var/www/public

EXPOSE 80

# --- Deep clean configuration, route, asset metrics caches, migrate, and run ---
CMD php artisan config:clear && \
    php artisan view:clear && \
    php artisan route:clear && \
    php artisan cache:clear && \
    php artisan migrate --force && \
    service nginx start && \
    php-fpm