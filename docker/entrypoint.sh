#!/usr/bin/env bash
set -e

# Wait for SQL Server (skip if DB_HOST unreachable check disabled)
if [ "${WAIT_FOR_DB:-1}" = "1" ] && [ -n "${DB_HOST:-}" ]; then
    echo "[entrypoint] Waiting for SQL Server at ${DB_HOST}:${DB_PORT:-1433}..."
    for i in $(seq 1 60); do
        if (echo > /dev/tcp/${DB_HOST}/${DB_PORT:-1433}) >/dev/null 2>&1; then
            echo "[entrypoint] SQL Server is up."
            break
        fi
        sleep 2
    done
fi

# Ensure writable runtime dirs
mkdir -p /var/www/html/storage/temp_facturas /var/www/html/archivos_json
chown -R www-data:www-data /var/www/html/storage /var/www/html/archivos_json 2>/dev/null || true

exec "$@"
