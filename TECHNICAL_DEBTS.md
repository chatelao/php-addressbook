# VERSION_AUDIT

This document provides an audit of the current versions of libraries used in this project and proposes "state of the art" versions or successors.

| Library | Current Version | Location | Proposed Successor/Version | Notes |
| :--- | :--- | :--- | :--- | :--- |
| Z-Push | 2.2.12 | `z-push/` | Z-Push 2.7.x | High-performance Open Source ActiveSync implementation. |
| HybridAuth | 2.1.0 | `hybridauth/` | Hybridauth 3.x | Major rewrite, more modern and PSR compliant. |
| PHP Excel Reader | 2.21 | `lib/excel_reader2.php` | PhpSpreadsheet | The official successor to PHPExcel/PHP Excel Reader. |
| parseCSV | 0.4.3 beta | `lib/parsecsv.lib.php` | php-parsecsv 1.3.x | Active fork of the original parseCSV library. |
| PHP-gettext | 1.0 | `lib/gettext/` | Native gettext / Symfony Translation | Native extension is faster; Symfony is more feature-rich. |
| Identicon | N/A | `lib/identicon.php` | bit-wasp/identicon | Modern, well-maintained identicon generation. |
| NoGray jscalendar | N/A | `js/jscalendar/` | Flatpickr / Native Date | Modern, accessible, and lightweight alternatives. |
| Table Sort | N/A | `js/tablesort.min.js` | Vanilla JS | Transition to modern sorting solution. |
| MooTools | 1.11 | `js/jscalendar/mootools.v1.11.js` | N/A (Migrate to Vanilla JS) | MooTools is largely obsolete in modern web development. |
