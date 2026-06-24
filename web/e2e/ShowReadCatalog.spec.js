import { test, expect } from '@playwright/test';

test('Show Read Catalog', async ({ page }) => {
  test.setTimeout(120000);

  // ── Login ──────────────────────────────────────────────────────────────
  await page.goto('http://127.0.0.1:8000/');
  await page.getByRole('link', { name: 'Login' }).click();

  await page.getByRole('textbox', { name: 'Email address' }).fill('lyrafaiqb@gmail.com');
  await page.getByRole('textbox', { name: 'Password' }).fill('#Tiaranac31');
  await page.getByRole('button', { name: 'Sign In' }).click();

  await page.waitForLoadState('networkidle');

  // ── Navigasi ke Catalog ────────────────────────────────────────────────
  await page.goto('http://127.0.0.1:8000/catalog', { waitUntil: 'domcontentloaded' });

  // ── Klik produk ───────────────────────────────────────────────────────
  const product = page.getByRole('link', { name: 'Glowsophy Watermelon' });
  await expect(product).toBeVisible({ timeout: 15000 });
  await product.click();

  // ── Verifikasi halaman detail produk ──────────────────────────────────
  await page.waitForLoadState('domcontentloaded');

  // Gunakan selector spesifik breadcrumb, bukan text=Moisturizer yang ambigu
  const breadcrumb = page.locator('span.pd-breadcrumb-current');
  await expect(breadcrumb).toBeVisible({ timeout: 10000 });
  await expect(breadcrumb).toHaveText('Moisturizer');

  // Verifikasi nama produk juga tampil
  await expect(page.locator('h1.pd-name')).toContainText('Glowsophy Watermelon');

  // ── Klik link Home di breadcrumb ──────────────────────────────────────
  await page.getByRole('link', { name: 'Home' }).click();
  await page.waitForLoadState('domcontentloaded');

  // ── Verifikasi kembali ke Home ─────────────────────────────────────────
  await expect(page).toHaveURL('http://127.0.0.1:8000/');
});