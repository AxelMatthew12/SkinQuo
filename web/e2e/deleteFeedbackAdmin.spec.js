import { test, expect } from '@playwright/test';

test('delete feedback admin', async ({ page }) => {
  // 1. Login
  await page.goto('/');
  await page.waitForLoadState('domcontentloaded');

  await page.getByRole('link', { name: 'Login' }).click();
  await page.waitForLoadState('domcontentloaded');

  await page.getByRole('textbox', { name: 'Email address' }).fill('admin@skinquo.com');
  await page.getByRole('textbox', { name: 'Password' }).fill('#Admin0101');
  await page.getByRole('button', { name: 'Sign In' }).click();

  await page.waitForURL('**/admin/**', { timeout: 30000 });

  // 2. Langsung ke feedback
  await page.goto('/admin/feedback');
  await page.waitForLoadState('domcontentloaded');

  // 3. Klik Delete Feedback di row pertama
  await page.waitForSelector('[aria-label="Delete Feedback"]', { state: 'visible', timeout: 15000 });
  await page.getByLabel('Delete Feedback').first().click();

  // 4. Tunggu modal lalu klik Batal
  await page.waitForTimeout(1000);
  await page.getByRole('button', { name: 'Batal' }).click();
  await page.waitForTimeout(500);

  // 5. Klik Delete Feedback lagi
  await page.waitForSelector('[aria-label="Delete Feedback"]', { state: 'visible', timeout: 15000 });
  await page.getByLabel('Delete Feedback').first().click();

  // 6. Tunggu modal lalu klik Hapus
  await page.waitForTimeout(1000);
  await page.getByRole('button', { name: 'Hapus' }).click();
  await page.waitForLoadState('domcontentloaded');
});