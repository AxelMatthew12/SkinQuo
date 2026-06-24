import { test, expect } from '@playwright/test';

test('read article admin', async ({ page }) => {
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

  // 3. Klik Read Article pertama
  await page.waitForSelector('[title="Read Article"]', { state: 'visible', timeout: 15000 });
  await page.getByTitle('Read Article').first().click();

  // 4. Tutup modal
  await page.waitForSelector('button:has-text("Tutup")', { state: 'visible', timeout: 15000 });
  await page.getByRole('button', { name: 'Tutup' }).click();
  await page.waitForLoadState('domcontentloaded');
});