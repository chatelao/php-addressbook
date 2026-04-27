# Product Summary - PHP Address Book

## Overview
PHP Address Book is a web-based application for managing contacts. It provides a simple yet feature-rich interface for maintaining an address book, organizing contacts into groups, and synchronizing with various devices and platforms.

## Key Features
- **Contact Management:** Create, read, update, and delete contact information including names, addresses, phone numbers, emails, birthdays, and photos.
- **Group Organization:** Group contacts for better organization and perform bulk actions like sending emails or deleting members.
- **Search & Filtering:** Fast search capabilities with AJAX support for real-time filtering of contact lists.
- **Birthday Reminders:** View upcoming birthdays and export them as an iCalendar feed.
- **Import & Export:** Support for various formats including vCard (individual or bulk), CSV, Excel, and LDIF.
- **Map Integration:** Visualize contact addresses using Google Maps integration.
- **Mobile Synchronization:** Integrated Z-Push support for ActiveSync, allowing synchronization with smartphones and other devices.
- **Authentication & Social Sign-in:** Support for traditional login and social sign-in via Facebook, Google, Yahoo, and Microsoft (HybridAuth).
- **Multi-language Support:** Translation system with support for numerous languages.

## Technical Stack
- **Language:** PHP (compatible with PHP 5.4 up to 7.0 via mysqli shim).
- **Database:** MySQL.
- **Frontend:** HTML, CSS, JavaScript (MooTools 1.11).
- **Libraries:**
  - Z-Push (ActiveSync synchronization)
  - HybridAuth (Social authentication)
  - PHP Excel Reader
  - parseCSV
  - SimpleTest (Testing framework)

## Application Pages

| Page | Description |
| :--- | :--- |
| `index.php` | **Home Page**: Displays the contact list, search bar, and group filter. |
| `edit.php` | **Add/Edit**: Form for adding new contacts or modifying existing ones. Includes a "Quick Add" feature. |
| `view.php` | **Details/Print**: Displays full details of a contact or a printable view of all contacts. |
| `group.php` | **Groups**: Manage contact groups (create, edit, delete, and manage members). |
| `birthdays.php` | **Birthdays**: Shows a list of upcoming birthdays and provides an iCalendar export. |
| `export.php` | **Export**: Options to export contacts in vCard, CSV, or Excel formats. |
| `import.php` | **Import**: Upload and import contacts from LDIF, VCF, CSV, or XLS files. |
| `preferences.php` | **Preferences**: Configure user settings like default mailer and social sign-in. |
| `map.php` | **Map**: Displays contacts' locations on Google Maps. |
| `diag.php` | **Diagnostics**: System self-checks and statistics (requires root permissions). |
| `doodle.php` | **Doodle**: Scheduling/polling feature for selected participants. |
| `vcard.php` | **vCard Download**: Generates and serves a vCard file for a specific contact. |
| `csv.php` | **CSV Export**: Directly generates a CSV file of contacts. |
| `delete.php` | **Delete**: Handles the deletion of one or more contacts. |
| `photo.php` | **Photo**: Serves the stored photo for a contact. |
| `search.php` | **Search**: AJAX endpoint for contact searching. |
| `signin/` | **Sign In**: Handles user authentication. |
| `register/` | **Register**: New user registration pages. |
