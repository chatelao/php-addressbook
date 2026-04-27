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
    - [ ] **Resolve session warnings**: Address `session_start()` and other session-related warnings that became more strict in PHP 8.x.
- [ ] **Responsive UI**: Implement a mobile-first responsive design using modern CSS (Flexbox/Grid).
- [ ] **Database Layer Refactor**
    - [x] **Audit legacy usage**: (Completed: 2026-04-27) Identified and documented all `mysql_*` function calls in `TECHNICAL_DEBTS_MYSQL.md`.
    - [ ] **Design Abstraction Layer**: Create a `mysqli`-based database wrapper or select a lightweight Query Builder.
    - [ ] **Migrate Connection Logic**: Update `include/dbconnect.php` to use the new abstraction.
    - [ ] **Phased Migration**: Systematically replace `mysql_shim.php` calls with the new abstraction.

### Phase 3: Technical Debt Cleanup
- [ ] **Remove MooTools**: Completely remove MooTools 1.11 and migrate `jscalendar` to a modern, lightweight date picker like **Flatpickr**.
- [x] **Modernize Table Actions**: (Completed: 2026-04-27) Removed the unreferenced `js/tableActions.min.js`. Further modernization can focus on native JS or future DataTables integration if needed.
- [ ] **Migrate Testing Framework**: Transition from SimpleTest to **PHPUnit** for more robust testing and PHP 8.x compatibility.

### Ongoing Modernization
- [ ] **Upgrade parseCSV**: Update `lib/parsecsv.lib.php` from 0.4.3 beta to the active fork version 1.3.x.
- [ ] **Modernize Translation Engine**: Replace legacy **PHP-gettext 1.0** with native PHP gettext or Symfony Translation.
- [ ] **Modernize Identicon Generation**: Replace the local `lib/identicon.php` with a modern library like `bit-wasp/identicon`.
- [ ] **Modernize Table Sorting**: Replace the legacy `js/tablesort.min.js` with native DataTables sorting capabilities.

---

## Completed Tasks

- [x] **Fix `deprecated` column filtering logic**: (Completed: 2025-05-22) The application filters using `WHERE deprecated IS NULL`, but the schema defines it as `NOT NULL DEFAULT '1000-01-01 00:00:00'`.
