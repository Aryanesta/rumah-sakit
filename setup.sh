#!/usr/bin/env bash

set -e

echo "========================================="
echo "  Rumah Sakit - Laravel Docker Setup     "
echo "========================================="

# 1. Check if Docker is running
if ! docker info > /dev/null 2>&1; then
    echo "❌ Error: Docker is not running. Please open Docker Desktop and try again."
    exit 1
fi
echo "✅ Docker daemon is active."

# 2. Check if Laravel is already installed
if [ ! -f "artisan" ]; then
    echo "📦 Scaffolding fresh Laravel project in the current directory..."
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php84-composer:latest \
        bash -c "composer create-project laravel/laravel temp-app && cp -rn temp-app/. . && rm -rf temp-app"
    echo "✅ Laravel files generated."
else
    echo "ℹ️ Laravel files already present in directory."
fi

# 3. Setup .env file
if [ ! -f ".env" ]; then
    if [ -f ".env.example" ]; then
        cp .env.example .env
        echo "✅ Copied .env.example to .env"
    fi
fi

# Configure MySQL settings in .env for Docker Compose
if [ -f ".env" ]; then
    sed -i '' 's/^#* *DB_CONNECTION=.*/DB_CONNECTION=mysql/' .env 2>/dev/null || sed -i 's/^#* *DB_CONNECTION=.*/DB_CONNECTION=mysql/' .env
    sed -i '' 's/^#* *DB_HOST=.*/DB_HOST=mysql/' .env 2>/dev/null || sed -i 's/^#* *DB_HOST=.*/DB_HOST=mysql/' .env
    sed -i '' 's/^#* *DB_PORT=.*/DB_PORT=3306/' .env 2>/dev/null || sed -i 's/^#* *DB_PORT=.*/DB_PORT=3306/' .env
    sed -i '' 's/^#* *DB_DATABASE=.*/DB_DATABASE=rumah_sakit/' .env 2>/dev/null || sed -i 's/^#* *DB_DATABASE=.*/DB_DATABASE=rumah_sakit/' .env
    sed -i '' 's/^#* *DB_USERNAME=.*/DB_USERNAME=sail/' .env 2>/dev/null || sed -i 's/^#* *DB_USERNAME=.*/DB_USERNAME=sail/' .env
    sed -i '' 's/^#* *DB_PASSWORD=.*/DB_PASSWORD=secret/' .env 2>/dev/null || sed -i 's/^#* *DB_PASSWORD=.*/DB_PASSWORD=secret/' .env
    echo "✅ Configured .env with Docker MySQL credentials."
fi

# 4. Ensure Laravel Sail is installed
if ! grep -q "laravel/sail" composer.json 2>/dev/null; then
    echo "⛵ Installing Laravel Sail..."
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php84-composer:latest \
        composer require laravel/sail --dev
    echo "✅ Laravel Sail installed."
fi

# 5. Install Laravel Breeze (Blade + Alpine.js + Tailwind CSS) if not installed
if ! grep -q "alpinejs" package.json 2>/dev/null; then
    echo "🎨 Installing Laravel Breeze (Blade & Alpine.js)..."
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php84-composer:latest \
        bash -c "composer require laravel/breeze --dev && php artisan breeze:install blade --no-interaction"
    echo "✅ Breeze with Alpine.js installed."
fi

# 6. Start Docker containers via Sail
echo "🚀 Starting Docker containers (App & MySQL)..."
./vendor/bin/sail up -d

# 7. Generate application key
echo "🔑 Generating Application Key..."
./vendor/bin/sail artisan key:generate

# 8. Wait for MySQL to be ready and run migrations
echo "⏳ Waiting for MySQL database to be ready..."
until ./vendor/bin/sail mysqladmin ping -psecret --silent > /dev/null 2>&1; do
    sleep 2
done

echo "🗄️ Running database migrations..."
./vendor/bin/sail artisan migrate --force

# 9. Install NPM dependencies
echo "📦 Installing npm dependencies..."
./vendor/bin/sail npm install

echo ""
echo "========================================="
echo "🎉 Setup Complete!"
echo "========================================="
echo "• App URL:        http://localhost"
echo "• MySQL Host:     127.0.0.1:3306 (User: sail / Pass: secret / DB: rumah_sakit)"
echo ""
echo "Helpful commands using ./dev-docker.sh:"
echo "  ./dev-docker.sh up             # Start containers"
echo "  ./dev-docker.sh down           # Stop containers"
echo "  ./dev-docker.sh npm run dev    # Start Vite hot-reload server"
echo "  ./dev-docker.sh shell          # Connect to container CLI"
echo "  ./dev-docker.sh artisan ...    # Run artisan commands"
echo "  ./dev-docker.sh mysql          # Connect to MySQL database CLI"
echo "========================================="
