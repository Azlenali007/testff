#!/bin/bash
set -e

# Ensure MariaDB server is active
if ! mysqladmin ping --silent 2>/dev/null; then
    echo "Starting MariaDB service..."
    service mariadb start || /usr/bin/mysqld_safe --user=mysql &
    sleep 2
fi

# Run database setup if tables not initialized
if [ -f "database/setup.php" ]; then
    php database/setup.php
fi

echo "Starting N.A Fresh Fruits & Coconuts PHP server on port 3000..."
exec php -S 0.0.0.0:3000 -t public router.php
