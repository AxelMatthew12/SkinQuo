import { test, expect } from '@playwright/test';

test('show product admin', async ({ page }) => {
  // 1. Buka halaman utama
  await page.goto('/');
  await page.waitForLoadState('networkidle');

  // 2. Klik Login
  await page.getByRole('link', { name: 'Login' }).click();
  await page.waitForLoadState('networkidle');

  // 3. Isi form login
  await page.getByRole('textbox', { name: 'Email address' }).fill('admin@skinquo.com');
  await page.getByRole('textbox', { name: 'Password' }).fill('#Admin0101');

  // 4. Klik Sign In
  await page.getByRole('button', { name: 'Sign In' }).click();
  await page.waitForLoadState('networkidle');

  // 5. Ke admin dashboard
  await page.goto('/admin/dashboard');
  await page.waitForLoadState('networkidle');

  // 6. Klik Inventory
  await page.getByRole('link', { name: ' Inventory Inventory' }).click();
  await page.waitForLoadState('networkidle');

  // 7. Klik View Detail item pertama
  await page.getByTitle('View Detail').first().click();
  await page.waitForLoadState('networkidle');
});