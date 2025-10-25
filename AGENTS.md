# Agent Instructions

This document provides instructions for agents working on this codebase.

## Offline Regression Testing

To run the full test suite in an environment that mimics the CI setup, you can use the `regression-tests.sh` script. This script automates the test environment setup, including the database.

**Prerequisites:**

*   **PHP 5.4:** You must have PHP 5.4 installed and available in your system's PATH.
*   **MySQL 5.5:** A MySQL 5.5 server must be running.
*   **Database User:** A MySQL user named `root` with the password `root` must exist and have privileges to create and drop databases.

**Usage:**

```bash
bash .github-offline/regression-tests.sh
```

The script will handle the following:

1.  Drop and recreate the `addressbook` test database.
2.  Import the database schema.
3.  Configure the application to use the test database.
4.  Start a temporary PHP built-in web server.
5.  Run the SimpleTest suite.
6.  Stop the web server.
