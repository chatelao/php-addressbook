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

- [ ] **Modernize Table Sorting**: Replace the legacy `js/tablesort.min.js` with native DataTables sorting capabilities.
- [ ] **Modernize Identicon Generation**: Replace the local `lib/identicon.php` with a modern library like `bit-wasp/identicon`.
- [ ] **Modernize Translation Engine**: Replace legacy **PHP-gettext 1.0** with native PHP gettext or Symfony Translation.
- [ ] **Upgrade parseCSV**: Update `lib/parsecsv.lib.php` from 0.4.3 beta to the active fork version 1.3.x.

### Phase 3: Technical Debt Cleanup
- [ ] **Migrate Testing Framework**: Transition from SimpleTest to **PHPUnit** for more robust testing and PHP 8.x compatibility.
- [ ] **Modernize Table Actions**: Replace custom `js/tableActions.min.js` with modern Vanilla JS or DataTables features.
- [ ] **Remove MooTools**: Completely remove MooTools 1.11 and migrate `jscalendar` to a modern, lightweight date picker like **Flatpickr**.

### Phase 2: Core Improvements
- [ ] **Database Layer Refactor**: Transition from the `mysql_shim.php` compatibility layer to native `mysqli` or a modern ORM/Query Builder.
- [ ] **Responsive UI**: Implement a mobile-first responsive design using modern CSS (Flexbox/Grid).
- [ ] **PHP 8.x Native Support**: Resolve all remaining incompatibilities in the core logic and testing framework to ensure full PHP 8.x stability.

### Phase 1: Dependency Modernization
- [ ] Upgrade **Z-Push** from 2.2.12 to 2.7.x.
- [ ] Upgrade **HybridAuth** from 2.1.0 to 3.x.
- [ ] Replace **PHP Excel Reader 2.21** with **PhpSpreadsheet**.
- [ ] Upgrade **DataTables** from 1.9.4 to 2.x.
- [ ] Upgrade **jQuery** from 1.8.2 to 3.7.x.

---

## Completed Tasks

- [x] **Fix `deprecated` column filtering logic**: (Completed: 2025-05-22) The application filters using `WHERE deprecated IS NULL`, but the schema defined it as `NOT NULL DEFAULT '1000-01-01 00:00:00'`. Fixed by adding surrogate PKs and making the column nullable.
