# MIGRATION ROADMAP

This document outlines the detailed, granular steps for modernizing and migrating the PHP Address Book project. It serves as a specialized extension of `ROADMAP.md`.

## Migration Rules
- **Execution Order**: Tasks are executed from **bottom to top**.
- **New Tasks**: New tasks are added to the **top** of the list.
- **Completion**: Tasks are marked as completed with a timestamp when finished.

---

## Open Tasks

### Phase 1: Dependency Modernization
- [ ] **Validate jQuery Usage**
    - [ ] Perform a full UI audit using browser developer tools to check if `js/jquery-1.8.2.min.js` is actually loaded and used.
    - [ ] Deep grep for `jQuery(` and `$( ` in all `.php`, `.js`, and `.html` files.
    - [ ] If confirmed unused, replace modernization task with "Remove unused jQuery assets".
- [ ] **Validate DataTables Usage**
    - [ ] Perform a full UI audit to check if `js/jquery.dataTables.min.js` is initialized on any table (check for `.dataTable()` or `.DataTable()` calls).
    - [ ] If confirmed unused, replace modernization task with "Remove unused DataTables assets".
- [ ] Replace **PHP Excel Reader 2.21** with **PhpSpreadsheet**.
- [ ] Upgrade **HybridAuth** from 2.1.0 to 3.x.
- [ ] Upgrade **Z-Push** from 2.2.12 to 2.7.x.

### Phase 2: Core Improvements
- [ ] **PHP 8.x Native Support**
    - [ ] **Harden `mysql_shim.php`**: Add explicit `is_object` or `mysqli_result` checks for all parameters passed to `mysqli_*` functions to prevent `TypeError` when a query fails and returns `false`.
    - [ ] **Patch SimpleTest**: Identify and fix all occurrences in `test/simpletest/` where `count()` is called on null or non-countable types, ensuring the test suite can run on PHP 8.x.
    - [ ] **Resolve session warnings**: Address `session_start()` and other session-related warnings that became more strict in PHP 8.x.
- [ ] **Responsive UI**: Implement a mobile-first responsive design using modern CSS (Flexbox/Grid).
- [ ] **Database Layer Refactor**
    - [ ] Identify and document all `mysql_*` function calls.
    - [ ] Create a `mysqli`-based database wrapper/abstraction layer.
    - [ ] Phased replacement of `mysql_shim.php` calls with the new abstraction.

### Phase 3: Technical Debt Cleanup
- [ ] **Remove MooTools**: Completely remove MooTools 1.11 and migrate `jscalendar` to a modern, lightweight date picker like **Flatpickr**.
- [ ] **Modernize Table Actions**: Replace custom `js/tableActions.min.js` with modern Vanilla JS or DataTables features.
- [ ] **Migrate Testing Framework**: Transition from SimpleTest to **PHPUnit** for more robust testing and PHP 8.x compatibility.

### Ongoing Modernization
- [ ] **Upgrade parseCSV**: Update `lib/parsecsv.lib.php` from 0.4.3 beta to the active fork version 1.3.x.
- [ ] **Modernize Translation Engine**: Replace legacy **PHP-gettext 1.0** with native PHP gettext or Symfony Translation.
- [ ] **Modernize Identicon Generation**: Replace the local `lib/identicon.php` with a modern library like `bit-wasp/identicon`.
- [ ] **Modernize Table Sorting**: Replace the legacy `js/tablesort.min.js` with native DataTables sorting capabilities.

---

## Completed Tasks

- [x] **Fix `deprecated` column filtering logic**: (Completed: 2025-05-22) The application filters using `WHERE deprecated IS NULL`, but the schema defines it as `NOT NULL DEFAULT '1000-01-01 00:00:00'`.
