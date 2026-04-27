# Legacy MySQL Function Audit

This document identifies all legacy `mysql_*` function calls that currently rely on the `mysql_shim.php` compatibility layer.

## Summary of Function Usage

| Function | Count |
| :--- | :--- |
| `mysql_query` | 105 |
| `mysql_fetch_array` | 45 |
| `mysql_numrows` | 26 |
| `mysql_real_escape_string` | 23 |
| `mysql_num_rows` | 18 |
| `mysql_error` | 13 |
| `mysql_select_db` | 6 |
| `mysql_connect` | 6 |
| `mysql_shim` | 5 |
| `mysql_errno` | 4 |
| `mysql_real_escape` | 1 |
| `mysql_ping` | 1 |
| `mysql_close` | 1 |

## Usage by File

| File | Legacy Calls | Details |
| :--- | :--- | :--- |
| `./group.php` | 24 | mysql_query (13),mysql_fetch_array (6) mysql_numrows (5) |
| `./include/address.class.php` | 20 | mysql_query (11),mysql_real_escape_string (3) mysql_numrows (2),mysql_fetch_array (2) mysql_errno (2),mysql_error (1) |
| `./z-push/backend/phpaddressbook/address.class.php` | 18 | mysql_query (11),mysql_real_escape_string (3) mysql_numrows (2),mysql_fetch_array (2) |
| `./register/user_add_save.php` | 17 | mysql_real_escape_string (7),mysql_query (5) mysql_num_rows (3),mysql_error (2) |
| `./z-push/backend/phpaddressbook/phpaddressbook.php` | 14 | mysql_query (5),mysql_fetch_array (3) mysql_shim (1),mysql_select_db (1) mysql_ping (1),mysql_errno (1) mysql_connect (1),mysql_close (1) |
| `./include/login.inc.php` | 12 | mysql_real_escape_string (3),mysql_query (3) mysql_numrows (3),mysql_fetch_array (3) |
| `./edit.php` | 11 | mysql_query (4),mysql_fetch_array (4) mysql_numrows (3) |
| `./include/dbconnect.php` | 10 | mysql_query (4),mysql_real_escape_string (2) mysql_shim (1),mysql_select_db (1) mysql_errno (1),mysql_connect (1) |
| `./z-push/backend/phpaddressbook/login.inc.php` | 9 | mysql_real_escape_string (3),mysql_query (2) mysql_numrows (2),mysql_fetch_array (2) |
| `./register/login_config.php` | 9 | mysql_query (2),mysql_error (2) mysql_select_db (1),mysql_real_escape_string (1) mysql_num_rows (1),mysql_fetch_array (1) mysql_connect (1) |
| `./register/reset_password.php` | 8 | mysql_query (4),mysql_num_rows (2) mysql_fetch_array (1),mysql_error (1) |
| `./index.php` | 7 | mysql_numrows (3),mysql_query (2) mysql_fetch_array (2) |
| `./register/checklogin.php` | 6 | mysql_error (2),mysql_select_db (1) mysql_query (1),mysql_num_rows (1) mysql_connect (1) |
| `./register/auth_check_header.php` | 6 | mysql_query (3),mysql_num_rows (2) mysql_fetch_array (1) |
| `./diag.php` | 6 | mysql_query (3),mysql_num_rows (2) mysql_fetch_array (1) |
| `./view.php` | 5 | mysql_query (2),mysql_fetch_array (2) mysql_numrows (1) |
| `./register/traffic.php` | 5 | mysql_query (3),mysql_num_rows (1) mysql_fetch_array (1) |
| `./register/router.php` | 4 | mysql_query (2),mysql_num_rows (1) mysql_fetch_array (1) |
| `./register/master_inc.php` | 4 | mysql_error (2),mysql_select_db (1) mysql_connect (1) |
| `./register/edit_user.php` | 4 | mysql_query (2),mysql_num_rows (1) mysql_fetch_array (1) |
| `./register/admin_index.php` | 4 | mysql_query (2),mysql_num_rows (1) mysql_fetch_array (1) |
| `./export.php` | 4 | mysql_query (2),mysql_fetch_array (2) |
| `./register/email_password_sender.php` | 3 | mysql_real_escape_string (1),mysql_query (1) mysql_num_rows (1) |
| `./photo.php` | 3 | mysql_query (1),mysql_numrows (1) mysql_fetch_array (1) |
| `./map.php` | 3 | mysql_query (2),mysql_fetch_array (1) |
| `./include/install.php` | 3 | mysql_select_db (1),mysql_query (1) mysql_connect (1) |
| `./include/export.xls-nokia.php` | 3 | mysql_query (1),mysql_numrows (1) mysql_fetch_array (1) |
| `./doodle.php` | 3 | mysql_query (1),mysql_numrows (1) mysql_fetch_array (1) |
| `./csv.php` | 3 | mysql_query (1),mysql_numrows (1) mysql_fetch_array (1) |
| `./birthdays.php` | 3 | mysql_query (1),mysql_num_rows (1) mysql_fetch_array (1) |
| `./vcard.php` | 2 | mysql_query (1),mysql_fetch_array (1) |
| `./register/reset_password_save.php` | 2 | mysql_query (1),mysql_error (1) |
| `./register/email_sent.php` | 2 | mysql_query (1),mysql_num_rows (1) |
| `./register/edit_user_save.php` | 2 | mysql_query (1),mysql_error (1) |
| `./register/delete_user.php` | 2 | mysql_query (1),mysql_error (1) |
| `./include/view.w.php` | 2 | mysql_query (1),mysql_fetch_array (1) |
| `./include/header.inc.php` | 2 | mysql_query (1),mysql_fetch_array (1) |
| `./delete.php` | 2 | mysql_query (1),mysql_numrows (1) |
| `./register/linktick.php` | 1 | mysql_query (1) |
| `./include/guess.inc.php` | 1 | mysql_real_escape (1) |
| `./include/group.class.php` | 1 | mysql_query (1) |
