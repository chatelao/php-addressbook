#!/bin/bash

# --- Pre-requisites ---
# 1. PHP 5.4 installed and in your PATH.
# 2. MySQL 5.5 server running.
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

# 3. Start PHP 5.4 Web Server
echo "Starting PHP 5.4 web server on localhost:8000..."
php -S localhost:8000 -t . &
PHP_SERVER_PID=$!
sleep 2 # Give the server a moment to start

# --- Test Execution ---

# 4. Set SERVER variables and run tests
echo "Running tests..."
export SERVER_NAME="localhost:8000"
export REQUEST_URI="/index.php"
php test/index.php
TEST_EXIT_CODE=$?

# --- Cleanup ---

# 5. Stop PHP Web Server
echo "Stopping PHP web server..."
kill $PHP_SERVER_PID

exit $TEST_EXIT_CODE
