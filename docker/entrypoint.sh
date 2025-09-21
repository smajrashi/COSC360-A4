#!/bin/bash
set -e

if [ "$DB_CONNECTION" = "pgsql" ]; then
  echo "Waiting for Postgres at ${DB_HOST}:${DB_PORT:-5432}..."
  until pg_isready -h "${DB_HOST}" -p "${DB_PORT:-5432}" >/dev/null 2>&1; do
    sleep 1
  done
fi

if [ -z "$APP_KEY" ]; then
  echo "APP_KEY not set — generating..."
  php artisan key:generate --ansi
fi

attempts=0
max_attempts=10
until php artisan migrate --force; do
  attempts=$((attempts+1))
  if [ $attempts -ge $max_attempts ]; then
    echo "Migrations failed after ${max_attempts} attempts — continuing."
    break
  fi
  echo "Migrate failed — retrying ($attempts/$max_attempts)..."
  sleep 2
done

php artisan config:cache || true
php artisan route:cache || true

exec "$@"
