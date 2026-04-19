# VERSION_AUDIT

This document provides an audit of the current versions of libraries used in this project and proposes "state of the art" versions or successors.

| Library | Current Version | Location | Proposed Successor/Version | Notes |
| :--- | :--- | :--- | :--- | :--- |
| Z-Push | 2.2.12 | `z-push/` | Z-Push 2.7.x | High-performance Open Source ActiveSync implementation. |
| HybridAuth | 2.1.0 | `hybridauth/` | Hybridauth 3.x | Major rewrite, more modern and PSR compliant. |
| PHP Excel Reader | 2.21 | `lib/excel_reader2.php` | PhpSpreadsheet | The official successor to PHPExcel/PHP Excel Reader. |
| parseCSV | 0.4.3 beta | `lib/parsecsv.lib.php` | php-parsecsv 1.3.x | Active fork of the original parseCSV library. |
| jQuery | 1.8.2 | `js/jquery-1.8.2.min.js` | jQuery 3.7.x | Significant security and performance improvements in 3.x. |
| DataTables | 1.9.4 | `js/jquery.dataTables.min.js` | DataTables 2.x | Latest version with many new features and better API. |
| PHP-gettext | 1.0 | `lib/gettext/` | Native gettext / Symfony Translation | Native extension is faster; Symfony is more feature-rich. |
| Identicon | N/A | `lib/identicon.php` | bit-wasp/identicon | Modern, well-maintained identicon generation. |
| NoGray jscalendar | N/A | `js/jscalendar/` | Flatpickr / Native Date | Modern, accessible, and lightweight alternatives. |
| Table Sort | N/A | `js/tablesort.min.js` | DataTables | DataTables (already used) provides superior sorting. |
| Table Actions | N/A | `js/tableActions.min.js` | Modern JS / DataTables | Can be replaced by custom modern JS or DataTables features. |
| MooTools | 1.11 | `js/jscalendar/mootools.v1.11.js` | N/A (Migrate to Vanilla JS) | MooTools is largely obsolete in modern web development. |
