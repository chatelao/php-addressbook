#!/bin/bash

# --- Pre-requisites ---
# 1. PHP installed and in your PATH.
# 2. MySQL server running.
# 3. A MySQL user 'root' with password 'root' having administrative privileges.

# --- Test Environment Setup ---

# 1. Setup Database
echo "Setting up the test database..."
mysql -u root -proot -e "DROP DATABASE IF EXISTS addressbook;"
mysql -u root -proot -e "CREATE DATABASE addressbook;"
mysql -u root -proot addressbook < addressbook.sql

# 2. Configure Database
echo "Configuring database..."
cp .github-offline/db.config.php config/cfg.db.php

# 3. Start PHP Web Server
echo "Starting PHP web server on localhost:8000..."
# Redirect server output to a log file
php -S localhost:8000 -t . > server.log 2>&1 &
PHP_SERVER_PID=$!
sleep 2 # Give the server a moment to start

# --- Test Execution ---

# 4. Set SERVER variables and run tests
echo "Running tests..."
export SERVER_NAME="localhost:8000"
export REQUEST_URI="/index.php"

# Check PHP version
PHP_VERSION=$(php -r 'echo PHP_MAJOR_VERSION;')

if [ "$PHP_VERSION" -ge 8 ]; then
    echo "PHP version 8+ detected. Attempting to run tests, but SimpleTest might be incompatible."
fi

php test/index.php
TEST_EXIT_CODE=$?

# --- Cleanup ---

# 5. Stop PHP Web Server
echo "Stopping PHP web server..."
kill $PHP_SERVER_PID

exit $TEST_EXIT_CODE
