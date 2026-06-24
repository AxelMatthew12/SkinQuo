import { test, expect } from '@playwright/test';
import path from 'path';

const fixturesDir = path.join(process.cwd(), 'e2e/fixtures');

test('knowledge dictionary', async ({ page }) => {
  // 1. Login
  await page.goto('/');
  await page.waitForLoadState('networkidle');

  await page.getByRole('link', { name: 'Login' }).click();
  await page.waitForLoadState('networkidle');

  await page.getByRole('textbox', { name: 'Email address' }).fill('admin@skinquo.com');
  await page.getByRole('textbox', { name: 'Password' }).fill('#Admin0101');
  await page.getByRole('button', { name: 'Sign In' }).click();
  await page.waitForLoadState('networkidle');

  // 2. Ke admin dashboard
  await page.goto('/admin/dashboard');
  await page.waitForLoadState('networkidle');

  // 3. Navigasi ke Knowledge Dictionary
  await page.getByRole('link', { name: ' Inventory Inventory' }).click();
  await page.waitForLoadState('networkidle');

  await page.getByRole('link', { name: ' Knowledge Dictionary' }).click();
  await page.waitForLoadState('networkidle');

  // 4. Download semua template
  const download0Promise = page.waitForEvent('download');
  await page.getByRole('link', { name: ' Template' }).first().click();
  const download0 = await download0Promise;

  const download1Promise = page.waitForEvent('download');
  await page.getByRole('link', { name: ' Template' }).nth(1).click();
  const download1 = await download1Promise;

  const download2Promise = page.waitForEvent('download');
  await page.getByRole('link', { name: ' Template' }).nth(2).click();
  const download2 = await download2Promise;

  const download3Promise = page.waitForEvent('download');
  await page.getByRole('link', { name: ' Template' }).nth(3).click();
  const download3 = await download3Promise;

  // 5. Upload file product dictionary
  await page.locator('.bi.bi-file-earmark-arrow-up').first().click();
  await page.locator('#file-product').setInputFiles(
    path.join(fixturesDir, 'template_product_dictionary (1).csv')
  );

  // 6. Upload file constraint/ingredient dictionary
  await page.locator('#zone-constraint').click();
  await page.locator('#file-constraint').setInputFiles(
    path.join(fixturesDir, 'template_ingredient_dictionary (1).csv')
  );

  // 7. Upload file skin type dictionary
  await page.locator('#zone-skintype-icon').click();
  await page.locator('#file-skintype').setInputFiles(
    path.join(fixturesDir, 'template_skin_type_dictionary.csv')
  );

  // 8. Upload file problem dictionary
  await page.getByLabel('Click to upload Max file size').setInputFiles(
    path.join(fixturesDir, 'template_problem_dictionary.csv')
  );

  // 9. Klik Process All
  page.once('dialog', dialog => {
    console.log(`Dialog message: ${dialog.message()}`);
    dialog.dismiss().catch(() => {});
  });
  await page.getByRole('button', { name: ' Process All' }).click();
  await page.waitForLoadState('networkidle');
});