# MIGRATION ROADMAP

This document outlines the detailed, granular steps for modernizing and migrating the PHP Address Book project. It serves as a specialized extension of `ROADMAP.md`.

## Migration Rules
- **Execution Order**: Tasks are executed from **bottom to top**.
- **New Tasks**: New tasks are added to the **top** of the list.
- **Completion**: Tasks are marked as completed with a timestamp when finished.

---

## Open Tasks

### Phase 1: Dependency Modernization
- [ ] **Upgrade jQuery**
    - [ ] Audit all jQuery usage in the codebase.
    - [ ] Integrate jQuery Migrate plugin to identify deprecated features.
    - [ ] Incremental version hops: Upgrade to 1.12.x, then 3.7.x.
- [ ] **Upgrade DataTables**
    - [ ] Audit DataTables API usage (legacy vs. modern).
    - [ ] Upgrade to DataTables 1.10 in compatibility mode.
    - [ ] Refactor legacy API calls to modern ones.
    - [ ] Upgrade to DataTables 2.x.
- [ ] Replace **PHP Excel Reader 2.21** with **PhpSpreadsheet**.
- [ ] Upgrade **HybridAuth** from 2.1.0 to 3.x.
- [ ] Upgrade **Z-Push** from 2.2.12 to 2.7.x.

### Phase 2: Core Improvements
- [ ] **PHP 8.x Native Support**: Resolve all remaining incompatibilities in the core logic and testing framework to ensure full PHP 8.x stability.
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
