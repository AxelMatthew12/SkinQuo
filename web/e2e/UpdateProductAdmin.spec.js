import { test, expect } from '@playwright/test';

test('update product admin', async ({ page }) => {
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

  // 3. Klik Edit Product
  await page.waitForSelector('[title="Edit Product"]', { state: 'visible', timeout: 15000 });
  await page.getByTitle('Edit Product').first().click();
  await page.waitForLoadState('domcontentloaded');

  // 4. Pilih kategori Face Wash
  await page.waitForSelector('select', { state: 'visible', timeout: 15000 });
  await page.getByRole('combobox').selectOption('Face Wash');

  // 5. Save Changes
  await page.waitForSelector('button:has-text("Save Changes")', { state: 'visible', timeout: 15000 });
  await page.getByRole('button', { name: ' Save Changes' }).click();
  await page.waitForLoadState('domcontentloaded');

  // 6. Kembali ke inventory
  await page.goto('/admin/inventory');
  await page.waitForLoadState('domcontentloaded');
});