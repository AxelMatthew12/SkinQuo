import { test, expect } from '@playwright/test';

test('update product admin', async ({ page }) => {
  await page.goto('http://127.0.0.1:8000/');
  await page.getByRole('link', { name: 'Login' }).click();
  await page.getByRole('textbox', { name: 'Email address' }).click();
  await page.getByRole('textbox', { name: 'Email address' }).press('CapsLock');
  await page.getByRole('textbox', { name: 'Email address' }).fill('A');
  await page.getByRole('textbox', { name: 'Email address' }).press('CapsLock');
  await page.getByRole('textbox', { name: 'Email address' }).fill('admin@skinquo.com');
  await page.getByRole('textbox', { name: 'Password' }).click();
  await page.getByRole('textbox', { name: 'Password' }).fill('#');
  await page.getByRole('textbox', { name: 'Password' }).press('CapsLock');
  await page.getByRole('textbox', { name: 'Password' }).fill('#A');
  await page.getByRole('textbox', { name: 'Password' }).press('CapsLock');
  await page.getByRole('textbox', { name: 'Password' }).fill('#Admin0101');
  await page.getByRole('button').first().click();
  await page.getByRole('button', { name: 'Sign In' }).click();
  await page.goto('http://127.0.0.1:8000/admin/dashboard');
  await page.getByRole('link', { name: ' Inventory Inventory' }).click();
  await page.getByTitle('Edit Product').first().click();
  await page.getByRole('combobox').selectOption('Face Wash');
  await page.getByRole('button', { name: ' Save Changes' }).click();
  await page.goto('http://127.0.0.1:8000/admin/inventory');
});