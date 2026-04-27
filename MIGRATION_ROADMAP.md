# MIGRATION ROADMAP

This document outlines the detailed, granular steps for modernizing and migrating the PHP Address Book project. It serves as a specialized extension of `ROADMAP.md`.

## Migration Rules
- **Execution Order**: Tasks are executed from **bottom to top**.
- **New Tasks**: New tasks are added to the **top** of the list.
- **Completion**: Tasks are marked as completed with a timestamp when finished.

---

## Open Tasks

### Phase 1: Dependency Modernization
- [x] **Remove unused jQuery, DataTables, and tableActions assets**: (Completed: 2026-04-27) Removed `js/jquery-1.8.2.min.js`, `js/jquery.dataTables.min.js`, and `js/tableActions.min.js` as they were confirmed to be unreferenced in the PHP codebase.
- [ ] Replace **PHP Excel Reader 2.21** with **PhpSpreadsheet**.
- [ ] Upgrade **HybridAuth** from 2.1.0 to 3.x.
- [ ] Upgrade **Z-Push** from 2.2.12 to 2.7.x.

### Phase 2: Core Improvements
- [ ] **PHP 8.x Native Support**
    - [x] **Harden `mysql_shim.php`**: (Completed: 2025-05-22) Added explicit `instanceof` checks for all parameters passed to `mysqli_*` functions to prevent `TypeError`.
    - [x] **Patch SimpleTest core for PHP 8.x**: (Completed: 2026-04-27) Added `SimpleTestCompatibility::count()` and updated all call sites in `test/simpletest/` to handle non-countable types. Also hardened `socket.php` against `fclose()` TypeErrors.
    - [x] **Fix PHP-gettext fatal error on PHP 8.x**: (Completed: 2026-04-27) Updated legacy constructors to `__construct()` in `lib/gettext/` to support PHP 8.0+.
    - [x] **Resolve session warnings**: (Completed: 2026-04-27) Added `session_status()` checks before `session_start()` in `signin/` and `hybridauth/` to prevent PHP 8.x warnings when a session is already active.
- [ ] **Responsive UI**
    - [x] **Add viewport meta tag**: (Completed: 2026-04-27) Updated `include/format.inc.php` with a modern viewport meta tag.
    - [x] **Convert fixed-width layout (#container) to fluid/responsive**: (Completed: 2026-04-27) Updated `style.css` to use percentages and `max-width` for core layout elements.
    - [ ] Implement a mobile-friendly navigation menu.
    - [ ] Implement responsive table patterns for the main contact list.
- [ ] **Database Layer Refactor**
    - [x] **Audit legacy usage**: (Completed: 2026-04-27) Identified and documented all `mysql_*` function calls in `TECHNICAL_DEBTS_MYSQL.md`.
    - [ ] **Design Abstraction Layer**
        - [x] **Define the DBAL interface**: (Completed: 2026-04-27) Created `include/database.interface.php` defining the core database operations.
        - [x] **Implement the core DBAL class using `mysqli`**: (Completed: 2026-04-27) Created `include/mysqli.database.php` as the primary implementation.
        - [x] **Implement support for prepared statements in the DBAL**: (Completed: 2026-04-27) Added `execute` method to `DatabaseInterface` and implemented it in `MysqliDatabase` using `mysqli_execute_query` with a fallback for PHP < 8.2.
    - [x] **Migrate Connection Logic**: (Completed: 2026-04-27) Updated `include/dbconnect.php` to use the `MysqliDatabase` abstraction while maintaining backward compatibility.
    - [ ] **Phased Migration**: Systematically replace `mysql_shim.php` calls with the new abstraction.
        - [ ] Migrate `include/address.class.php` to DBAL.
        - [x] **Migrate `include/group.class.php` and `group.php` to DBAL**: (Completed: 2026-04-27) Updated both files to use the DBAL abstraction with prepared statements for all database operations.
        - [ ] Migrate `include/login.inc.php` and authentication files to DBAL.
        - [ ] Migrate core pages (`index.php`, `edit.php`, `view.php`, `birthdays.php`) to DBAL.
        - [ ] Migrate registration module (`register/`) to DBAL.
        - [ ] Migrate Z-Push backend to DBAL.

### Phase 3: Technical Debt Cleanup
- [ ] **Remove MooTools**: Completely remove MooTools 1.11 and migrate `jscalendar` to a modern, lightweight date picker like **Flatpickr**.
- [x] **Modernize Table Actions**: (Completed: 2026-04-27) Removed the unreferenced `js/tableActions.min.js`. Further modernization can focus on native JS or future DataTables integration if needed.
- [ ] **Migrate Testing Framework**
    - [ ] Setup PHPUnit (Configuration and initial test suite).
    - [ ] Migrate core library tests to PHPUnit.
    - [ ] Migrate web/integration tests to PHPUnit.
    - [ ] Remove SimpleTest once migration is complete.

### Ongoing Modernization
- [ ] **Upgrade parseCSV**: Update `lib/parsecsv.lib.php` from 0.4.3 beta to the active fork version 1.3.x.
- [ ] **Modernize Translation Engine**: Replace legacy **PHP-gettext 1.0** with native PHP gettext or Symfony Translation.
- [ ] **Modernize Identicon Generation**: Replace the local `lib/identicon.php` with a modern library like `bit-wasp/identicon`.
- [ ] **Modernize Table Sorting**: Replace the legacy `js/tablesort.min.js` with native Vanilla JS sorting capabilities.

---

## Completed Tasks

- [x] **Fix `deprecated` column filtering logic**: (Completed: 2025-05-22) The application filters using `WHERE deprecated IS NULL`, but the schema defines it as `NOT NULL DEFAULT '1000-01-01 00:00:00'`.
