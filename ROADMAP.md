# ROADMAP

This document outlines the planned improvements and modernization steps for the PHP Address Book project.

## Roadmap Rules
- **Management**: This roadmap is managed by the AI Automation.
- **Execution Order**: Tasks are executed from **bottom to top**.
- **New Tasks**: New tasks are added to the **top** of the list.
- **Task Granularity**: Focus on modest, feasible, and reasonable steps. Larger goals should be broken down into smaller tasks.
- **Completion**: Tasks are marked as completed with a timestamp when finished and the related issue id.

---

## Open Tasks

- [ ] **Modernize Table Sorting**: Replace the legacy `js/tablesort.min.js` with native Vanilla JS sorting capabilities.
- [ ] **Modernize Identicon Generation**: Replace the local `lib/identicon.php` with a modern library like `bit-wasp/identicon`.
- [ ] **Modernize Translation Engine**: Replace legacy **PHP-gettext 1.0** with native PHP gettext or Symfony Translation.
- [ ] **Upgrade parseCSV**: Update `lib/parsecsv.lib.php` from 0.4.3 beta to the active fork version 1.3.x.

### Phase 3: Technical Debt Cleanup
- [ ] **Migrate Testing Framework**: Transition from SimpleTest to **PHPUnit** for more robust testing and PHP 8.x compatibility.
- [x] **Modernize Table Actions**: (Completed: 2026-04-27) Removed the unreferenced `js/tableActions.min.js`.
- [ ] **Remove MooTools**: Completely remove MooTools 1.11 and migrate `jscalendar` to a modern, lightweight date picker like **Flatpickr**.

### Phase 2: Core Improvements
- [ ] **Database Layer Refactor**: Transition from the `mysql_shim.php` compatibility layer to native `mysqli` or a modern ORM/Query Builder.
- [ ] **Responsive UI**: (Partially Completed: 2026-04-27) Modernized viewport meta tag and converted fixed-width layout to fluid. Further work needed for mobile navigation and tables.
- [ ] **PHP 8.x Native Support**: (Partially Completed: 2026-04-27) Hardened `mysql_shim.php` (2025) and patched SimpleTest core (2026) to handle PHP 8.x `count()` and `fclose()` changes. Further work needed on legacy libraries like PHP-gettext.

### Phase 1: Dependency Modernization
- [ ] Upgrade **Z-Push** from 2.2.12 to 2.7.x.
- [ ] Upgrade **HybridAuth** from 2.1.0 to 3.x.
- [ ] Replace **PHP Excel Reader 2.21** with **PhpSpreadsheet**.
- [x] **Remove unused jQuery and DataTables assets**: (Completed: 2026-04-27) Both `js/jquery-1.8.2.min.js` and `js/jquery.dataTables.min.js` were removed as they were not referenced in any `.php` files.

---

## Completed Tasks

- [x] **Fix `deprecated` column filtering logic**: (Completed: 2025-05-22) The application filters using `WHERE deprecated IS NULL`, but the schema defined it as `NOT NULL DEFAULT '1000-01-01 00:00:00'`. Fixed by adding surrogate PKs and making the column nullable.
