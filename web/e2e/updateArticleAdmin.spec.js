import { test, expect } from '@playwright/test';

test('update article admin', async ({ page }) => {
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

  // 3. Klik Edit Article di row pertama
  await page.waitForSelector('[aria-label="Edit Article"]', { state: 'visible', timeout: 15000 });
  await page.getByLabel('Edit Article').first().click();
  await page.waitForLoadState('domcontentloaded');

  // 4. Update judul artikel
  await page.waitForSelector('[name="title"], [aria-label="Judul Artikel *"]', { state: 'visible', timeout: 15000 });
  await page.getByRole('textbox', { name: 'Judul Artikel *' }).fill('lyraaafh');

  // 5. Save Article — tunggu redirect otomatis ke skin-guide
  await page.waitForSelector('button:has-text("Save Article")', { state: 'visible', timeout: 15000 });
  await page.getByRole('button', { name: 'Save Article' }).click();

  // Tunggu redirect setelah save
  await page.waitForURL('**/admin/skin-guide**', { timeout: 30000 });
  await page.waitForLoadState('domcontentloaded');
});