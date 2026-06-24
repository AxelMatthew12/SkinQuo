import { test, expect } from '@playwright/test';
import path from 'path';

const fixturesDir = path.join(process.cwd(), 'e2e/fixtures');

test('create article admin', async ({ page }) => {
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

  // 3. Klik Create Article
  await page.waitForSelector('a:has-text("Create Article")', { state: 'visible', timeout: 15000 });
  await page.getByRole('link', { name: ' Create Article' }).click();
  await page.waitForLoadState('domcontentloaded');

  // 4. Isi form artikel
await page.waitForSelector('[name="title"], [placeholder*="Title"], textarea, input[type="text"]', { state: 'visible', timeout: 15000 });
  await page.getByRole('textbox', { name: 'Article Title' }).fill('lyraaaaaaaaaaaa');
  await page.getByRole('textbox', { name: 'Article Content' }).fill('p');

  // 5. Upload gambar — input hidden, langsung setInputFiles tanpa klik
  await page.locator('#image_file').setInputFiles(
    path.join(fixturesDir, 'knowledge dict.png')
  );

  // 6. Pilih kategori
  await page.waitForSelector('select', { state: 'visible', timeout: 15000 });
  await page.getByLabel('Category').selectOption('BAHAN AKTIF');

  // 7. Klik tag pertama
  await page.waitForSelector('.tag-box', { state: 'visible', timeout: 15000 });
  await page.locator('.tag-box').first().click();

  // 8. Save Article
  await page.waitForSelector('button:has-text("Save Article")', { state: 'visible', timeout: 15000 });
  await page.getByRole('button', { name: ' Save Article' }).click();
  await page.waitForLoadState('domcontentloaded');

  // 9. Kembali ke skin guide
  await page.goto('/admin/skin-guide');
  await page.waitForLoadState('domcontentloaded');
});