import { test, expect } from '@playwright/test';

test('delete product admin', async ({ page }) => {
  // 1. Login
  await page.goto('/');
  await page.waitForLoadState('domcontentloaded');

  await page.getByRole('link', { name: 'Login' }).click();
  await page.waitForLoadState('domcontentloaded');

  await page.getByRole('textbox', { name: 'Email address' }).fill('admin@skinquo.com');
  await page.getByRole('textbox', { name: 'Password' }).fill('#Admin0101');
  await page.getByRole('button', { name: 'Sign In' }).click();

  await page.waitForURL('**/admin/**', { timeout: 30000 });

  // 2. Langsung ke inventory
  await page.goto('/admin/inventory');
  await page.waitForLoadState('domcontentloaded');

  // 3. Klik Delete Product
  await page.waitForSelector('[title="Delete Product"]', { state: 'visible', timeout: 15000 });
  await page.getByTitle('Delete Product').first().click();

  // 4. Konfirmasi Delete
  await page.waitForSelector('button:has-text("Delete Product")', { state: 'visible', timeout: 15000 });
  await page.getByRole('button', { name: 'Delete Product' }).click();
  await page.waitForLoadState('domcontentloaded');

  // 5. Kembali ke inventory
  await page.goto('/admin/inventory');
  await page.waitForLoadState('domcontentloaded');
});