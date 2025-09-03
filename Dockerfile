FROM php:8.4-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    npm \
    cron \
    iputils-ping

RUN apt-get update && apt-get install -y \
    libxml2-dev \
    && docker-php-ext-install xml
RUN docker-php-ext-install pdo_mysql gd zip

RUN npm install --global yarn

RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - 
RUN apt-get install -y nodejs

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql gd zip

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for Laravel application
RUN groupadd -g 1000 www && useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY --chown=www:www app /var/www

# Copy cronjob file
COPY cronjob /etc/cron.d/laravel-cron

# Apply appropriate permissions to the cronjob file
RUN chmod 0644 /etc/cron.d/laravel-cron

# Apply ownership to the log file for cron
RUN touch /var/log/cron.log && chown -f www:www /var/log/cron.log

# Start cron and PHP-FPM together
CMD cron && php-fpm

# Expose port 9000
EXPOSE 9000