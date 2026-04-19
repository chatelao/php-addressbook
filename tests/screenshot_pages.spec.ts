import { test } from '@playwright/test';

const pages = [
  { name: 'home', url: '/' },
  { name: 'add_new', url: '/edit.php' },
  { name: 'groups', url: '/group.php' },
  { name: 'birthdays', url: '/birthdays.php' },
  { name: 'print_all', url: '/view.php?all&print' },
  { name: 'print_phones', url: '/view.php?all&print&phones' },
  { name: 'export', url: '/export.php' },
  { name: 'import', url: '/import.php' },
];

test('take screenshots of pages', async ({ page }) => {
  for (const p of pages) {
    await page.goto('http://localhost:8000' + p.url);
    await page.screenshot({ path: `tests/screenshots/${p.name}.png`, fullPage: true });
  }
});
