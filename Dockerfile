# PHP 8.3 + Apache (Debian 12 bookworm) w/ Microsoft ODBC 18 + pdo_sqlsrv
FROM php:8.3-apache-bookworm

ARG DEBIAN_FRONTEND=noninteractive

# Mata hooks Post-Invoke de /etc/apt/apt.conf.d/docker-clean (rompen en hosts con storage driver problemático)
RUN rm -f /etc/apt/apt.conf.d/docker-clean \
    && echo 'Acquire::Check-Valid-Until "false";\nAPT::Update::Post-Invoke {};\nDPkg::Post-Invoke {};' > /etc/apt/apt.conf.d/00no-post-invoke \
    && mkdir -p /var/cache/apt/archives/partial /var/lib/apt/lists/partial

# System deps + Microsoft ODBC driver repo
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        gnupg2 curl ca-certificates apt-transport-https lsb-release \
        unixodbc-dev libxml2-dev libzip-dev libpng-dev libonig-dev \
        libcurl4-openssl-dev libssl-dev libicu-dev \
        zip unzip git \
    && curl -fsSL https://packages.microsoft.com/keys/microsoft.asc \
        | gpg --dearmor -o /usr/share/keyrings/microsoft.gpg \
    && echo "deb [arch=amd64,arm64 signed-by=/usr/share/keyrings/microsoft.gpg] https://packages.microsoft.com/debian/12/prod bookworm main" \
        > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update \
    && ACCEPT_EULA=Y apt-get install -y --no-install-recommends \
        msodbcsql18 mssql-tools18 \
    && rm -rf /var/lib/apt/lists/*

# PHP core extensions
RUN docker-php-ext-install -j$(nproc) \
        pdo pdo_mysql mysqli mbstring zip gd intl opcache bcmath

# sqlsrv + pdo_sqlsrv via PECL (pin para garantizar compat con PHP 8.3)
RUN pecl channel-update pecl.php.net \
    && pecl install sqlsrv-5.12.0 pdo_sqlsrv-5.12.0 \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv

# Apache modules
RUN a2enmod rewrite headers

# PHP runtime tuning
RUN { \
        echo "memory_limit=512M"; \
        echo "upload_max_filesize=64M"; \
        echo "post_max_size=64M"; \
        echo "max_execution_time=300"; \
        echo "date.timezone=America/Caracas"; \
        echo "display_errors=Off"; \
        echo "log_errors=On"; \
        echo "output_buffering=4096"; \
        echo "implicit_flush=Off"; \
        echo "zend.multibyte=Off"; \
    } > /usr/local/etc/php/conf.d/zz-app.ini

# Legacy OpenSSL config for BCV scraping (insecure ciphers)
COPY openssl_legacy.cnf /etc/ssl/openssl_legacy.cnf
ENV OPENSSL_CONF=/etc/ssl/openssl_legacy.cnf

# Apache vhost
COPY docker/apache-vhost.conf /etc/apache2/sites-available/000-default.conf

# Entrypoint waits for SQL Server before serving
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

WORKDIR /var/www/html
COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \; \
    && mkdir -p /var/www/html/storage/temp_facturas \
    && chmod -R 775 /var/www/html/storage /var/www/html/archivos_json 2>/dev/null || true

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["apache2-foreground"]
