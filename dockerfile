# File: Dockerfile

# Gunakan image PHP dengan Apache
FROM php:8.2-apache

# Set working directory di container
WORKDIR /var/www/html

# Update package list dan install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli mbstring exif pcntl bcmath gd zip

# Enable Apache mod_rewrite untuk clean URL
RUN a2enmod rewrite

# Copy semua file aplikasi ke container
COPY app/ /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Buat file update_status.php jika belum ada
RUN echo "<?php" > /var/www/html/update_status.php \
    && echo "include 'koneksi.php';" >> /var/www/html/update_status.php \
    && echo "if (\$_SERVER['REQUEST_METHOD'] == 'POST') {" >> /var/www/html/update_status.php \
    && echo "    \$id = \$_POST['id'] ?? '';" >> /var/www/html/update_status.php \
    && echo "    \$status = \$_POST['status_pengiriman'] ?? '';" >> /var/www/html/update_status.php \
    && echo "    if (\$id && \$status) {" >> /var/www/html/update_status.php \
    && echo "        \$stmt = \$koneksi->prepare('UPDATE penerima SET status_pengiriman = ? WHERE id = ?');" >> /var/www/html/update_status.php \
    && echo "        \$stmt->bind_param('si', \$status, \$id);" >> /var/www/html/update_status.php \
    && echo "        if (\$stmt->execute()) {" >> /var/www/html/update_status.php \
    && echo "            echo 'success';" >> /var/www/html/update_status.php \
    && echo "        } else {" >> /var/www/html/update_status.php \
    && echo "            echo 'error';" >> /var/www/html/update_status.php \
    && echo "        }" >> /var/www/html/update_status.php \
    && echo "        \$stmt->close();" >> /var/www/html/update_status.php \
    && echo "    } else {" >> /var/www/html/update_status.php \
    && echo "        echo 'invalid';" >> /var/www/html/update_status.php \
    && echo "    }" >> /var/www/html/update_status.php \
    && echo "}" >> /var/www/html/update_status.php \
    && echo "?>" >> /var/www/html/update_status.php

# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]