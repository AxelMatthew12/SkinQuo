import { test, expect } from '@playwright/test';

test('delete article admin', async ({ page }) => {
  // 1. Login
  await page.goto('/');
  await page.waitForLoadState('domcontentloaded');

  await page.getByRole('link', { name: 'Login' }).click();
  await page.waitForLoadState('domcontentloaded');

  await page.getByRole('textbox', { name: 'Email address' }).fill('admin@skinquo.com');
  await page.getByRole('textbox', { name: 'Password' }).fill('#Admin0101');
  await page.getByRole('button', { name: 'Sign In' }).click();

  await page.waitForURL('**/admin/**', { timeout: 30000 });

  // 2. Langsung ke skin guide
  await page.goto('/admin/skin-guide');
  await page.waitForLoadState('domcontentloaded');

  // 3. Klik Delete Article di row pertama
  await page.waitForSelector('[aria-label="Delete Article"]', { state: 'visible', timeout: 15000 });
  await page.getByLabel('Delete Article').first().click();

  // 4. Konfirmasi hapus
  await page.waitForSelector('button:has-text("Hapus")', { state: 'visible', timeout: 15000 });
  await page.getByRole('button', { name: 'Hapus' }).click();
  await page.waitForLoadState('domcontentloaded');

  // 5. Kembali ke skin guide
  await page.goto('/admin/skin-guide');
  await page.waitForLoadState('domcontentloaded');
});