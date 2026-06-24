import { test, expect } from '@playwright/test';
import path from 'path';

const fixturesDir = path.join(process.cwd(), 'e2e/fixtures');

test('knowledge dictionary', async ({ page }) => {
  // 1. Login
  await page.goto('/');
  await page.waitForLoadState('domcontentloaded');

  await page.getByRole('link', { name: 'Login' }).click();
  await page.waitForLoadState('domcontentloaded');

  await page.getByRole('textbox', { name: 'Email address' }).fill('admin@skinquo.com');
  await page.getByRole('textbox', { name: 'Password' }).fill('#Admin0101');
  await page.getByRole('button', { name: 'Sign In' }).click();

  await page.waitForURL('**/admin/**', { timeout: 30000 });

  // 2. Langsung goto inventory knowledge dictionary
  await page.goto('/admin/inventory?tab=skin-guide');
  await page.waitForLoadState('domcontentloaded');

  // 3. Pastikan halaman sudah load
  await page.waitForSelector('a:has-text("Knowledge Dictionary")', { state: 'visible', timeout: 20000 });
  await page.getByRole('link', { name: ' Knowledge Dictionary' }).click();
  await page.waitForLoadState('domcontentloaded');

  // 4. Download semua template
  const download0Promise = page.waitForEvent('download');
  await page.getByRole('link', { name: ' Template' }).first().click();
  await download0Promise;

  const download1Promise = page.waitForEvent('download');
  await page.getByRole('link', { name: ' Template' }).nth(1).click();
  await download1Promise;

  const download2Promise = page.waitForEvent('download');
  await page.getByRole('link', { name: ' Template' }).nth(2).click();
  await download2Promise;

  const download3Promise = page.waitForEvent('download');
  await page.getByRole('link', { name: ' Template' }).nth(3).click();
  await download3Promise;

  // 5. Upload file product dictionary
  await page.waitForSelector('.bi.bi-file-earmark-arrow-up', { state: 'visible', timeout: 15000 });
  await page.locator('.bi.bi-file-earmark-arrow-up').first().click();
  await page.waitForSelector('#file-product', { state: 'attached', timeout: 15000 });
  await page.locator('#file-product').setInputFiles(
    path.join(fixturesDir, 'template_product_dictionary.csv')
  );

  // 6. Upload file constraint/ingredient dictionary
  await page.waitForSelector('#zone-constraint', { state: 'visible', timeout: 15000 });
  await page.locator('#zone-constraint').click();
  await page.waitForSelector('#file-constraint', { state: 'attached', timeout: 15000 });
  await page.locator('#file-constraint').setInputFiles(
    path.join(fixturesDir, 'template_ingredient_dictionary.csv')
  );

  // 7. Upload file skin type dictionary
  await page.waitForSelector('#zone-skintype-icon', { state: 'visible', timeout: 15000 });
  await page.locator('#zone-skintype-icon').click();
  await page.waitForSelector('#file-skintype', { state: 'attached', timeout: 15000 });
  await page.locator('#file-skintype').setInputFiles(
    path.join(fixturesDir, 'template_skin_type_dictionary.csv')
  );

  // 8. Upload file problem dictionary
  await page.waitForSelector('label:has-text("Click to upload")', { state: 'visible', timeout: 15000 });
  await page.getByLabel('Click to upload Max file size').setInputFiles(
    path.join(fixturesDir, 'template_problem_dictionary.csv')
  );

  // 9. Klik Process All
  page.once('dialog', dialog => {
    console.log(`Dialog message: ${dialog.message()}`);
    dialog.dismiss().catch(() => {});
  });
  await page.waitForSelector('button:has-text("Process All")', { state: 'visible', timeout: 15000 });
  await page.getByRole('button', { name: ' Process All' }).click();
  await page.waitForLoadState('domcontentloaded');
});