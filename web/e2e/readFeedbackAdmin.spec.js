import { test, expect } from '@playwright/test';

test('read feedback admin', async ({ page }) => {
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

  // 3. Klik View Detail di row pertama
  await page.waitForSelector('[aria-label="View Detail"]', { state: 'visible', timeout: 15000 });
  await page.getByLabel('View Detail').first().click();
  await page.waitForLoadState('domcontentloaded');
});