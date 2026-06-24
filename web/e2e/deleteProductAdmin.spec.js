import { test, expect } from '@playwright/test';

test('test', async ({ page }) => {
  await page.goto('http://127.0.0.1:8000/');
  await page.getByRole('link', { name: 'Login' }).click();
  await page.getByRole('textbox', { name: 'Email address' }).click();
  await page.getByRole('textbox', { name: 'Email address' }).fill('admin@skinquo.com');
  await page.locator('div:nth-child(5)').click();
  await page.getByRole('textbox', { name: 'Password' }).fill('#');
  await page.getByRole('textbox', { name: 'Password' }).press('CapsLock');
  await page.getByRole('textbox', { name: 'Password' }).fill('#T');
  await page.getByRole('textbox', { name: 'Password' }).press('CapsLock');
  await page.getByRole('textbox', { name: 'Password' }).fill('#');
  await page.getByRole('textbox', { name: 'Password' }).press('CapsLock');
  await page.getByRole('textbox', { name: 'Password' }).fill('#A');
  await page.getByRole('textbox', { name: 'Password' }).press('CapsLock');
  await page.getByRole('textbox', { name: 'Password' }).fill('#Admin0101');
  await page.getByRole('button', { name: 'Sign In' }).click();
  await page.goto('http://127.0.0.1:8000/admin/dashboard');
  await page.getByRole('link', { name: ' Inventory Inventory' }).click();
  await page.getByTitle('Delete Product').first().click();
  await page.getByRole('button', { name: 'Delete Product' }).click();
  await page.goto('http://127.0.0.1:8000/admin/inventory');
});