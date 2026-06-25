import { test, expect } from '@playwright/test';

test('change password admin', async ({ page }) => {
  // 1. Login
  await page.goto('/');
  await page.waitForLoadState('domcontentloaded');

  await page.getByRole('link', { name: 'Login' }).click();
  await page.waitForLoadState('domcontentloaded');

  await page.getByRole('textbox', { name: 'Email address' }).fill('admin@skinquo.com');
  await page.getByRole('textbox', { name: 'Password' }).fill('#Admin01');
  await page.getByRole('button', { name: 'Sign In' }).click();

  await page.waitForURL('**/admin/**', { timeout: 30000 });

  // 2. Langsung ke halaman ubah password
  await page.goto('/admin/profile');
  await page.waitForLoadState('domcontentloaded');

  // 3. Klik Ubah Password
  await page.waitForSelector('a:has-text("Ubah Password")', { state: 'visible', timeout: 15000 });
  await page.getByRole('link', { name: 'Ubah Password' }).click();
  await page.waitForLoadState('domcontentloaded');

  // 4. Isi current password
  await page.waitForSelector('#currentPasswordInput', { state: 'visible', timeout: 15000 });
  await page.locator('#currentPasswordInput').fill('#Admin0101');

  // 5. Isi new password
  await page.locator('#newPasswordInput').fill('#Admin01');

  // 6. Isi confirm password
  await page.locator('#confirmPasswordInput').fill('#Admin01');

  // 7. Save Password
  await page.waitForSelector('button:has-text("Save Password")', { state: 'visible', timeout: 15000 });
  await page.getByRole('button', { name: ' Save Password' }).click();
  await page.waitForLoadState('domcontentloaded');

  // 8. Kembali ke profile
  await page.goto('/admin/profile');
  await page.waitForLoadState('domcontentloaded');
});