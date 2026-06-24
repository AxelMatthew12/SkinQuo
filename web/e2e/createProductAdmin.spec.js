import { test, expect } from '@playwright/test';

test('create product admin', async ({ page }) => {
  // 1. Login
  await page.goto('/');
  await page.waitForLoadState('domcontentloaded');

  await page.getByRole('link', { name: 'Login' }).click();
  await page.waitForLoadState('domcontentloaded');

  await page.getByRole('textbox', { name: 'Email address' }).fill('admin@skinquo.com');
  await page.getByRole('textbox', { name: 'Password' }).fill('#Admin0101');
  await page.getByRole('button', { name: 'Sign In' }).click();

  await page.waitForURL('**/admin/**', { timeout: 30000 });

  // 2. Langsung ke inventory
  await page.goto('/admin/inventory');
  await page.waitForLoadState('domcontentloaded');

  // 3. Klik ADD NEW PRODUCT
  await page.waitForSelector('a:has-text("ADD NEW PRODUCT")', { state: 'visible', timeout: 15000 });
  await page.getByRole('link', { name: ' ADD NEW PRODUCT' }).click();
  await page.waitForLoadState('domcontentloaded');

  // 4. Isi form product
  await page.waitForSelector('[placeholder*="Saffron"]', { state: 'visible', timeout: 15000 });
  await page.getByRole('textbox', { name: 'e.g. Saffron Infused Serum' }).fill('lyraaa');
  await page.getByRole('textbox', { name: 'e.g. COSRX, Skintific' }).fill('cosrx');

  await page.getByRole('combobox').selectOption('Moisturizer');

  await page.getByRole('textbox', { name: "Describe the product's" }).fill('oooo');
  await page.getByRole('textbox', { name: 'Step-by-step instructions for' }).fill('oo');
  await page.getByRole('textbox', { name: 'e.g. Water, Niacinamide 10%,' }).fill('oooo');

  await page.locator('input[name="harga_min"]').fill('20000');
  await page.locator('input[name="harga_max"]').fill('20000');

  await page.getByRole('textbox', { name: 'https://shopee.co.id/product/' }).fill('https://shopee.co.id/LINK-SHOPEE-VIDEO-AFFILIATE-i.25467071.25332476103');
  await page.getByRole('textbox', { name: 'https://images.example.com/' }).fill('https://down-id.img.susercontent.com/file/id-11134207-7r98v-lwr00rfrdnyl6a.webp');

  // 5. Save Product
  await page.waitForSelector('button:has-text("Save Product")', { state: 'visible', timeout: 15000 });
  await page.getByRole('button', { name: ' Save Product' }).click();
  await page.waitForLoadState('domcontentloaded');

  // 6. Kembali ke inventory
  await page.goto('/admin/inventory');
  await page.waitForLoadState('domcontentloaded');
});