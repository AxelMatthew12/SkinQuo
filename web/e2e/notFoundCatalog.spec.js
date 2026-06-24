import { test, expect } from '@playwright/test';

test('Catalog - Produk Tidak Ditemukan', async ({ page }) => {
  test.setTimeout(120000);

  // ── Login ─────────────────────────────────────────────────────────────
  await page.goto('http://127.0.0.1:8000/', { waitUntil: 'domcontentloaded' });

  const loginLink = page.getByRole('link', { name: 'Login' });
  const isLoginVisible = await loginLink.isVisible();

  if (isLoginVisible) {
    await loginLink.click();
    await page.waitForLoadState('domcontentloaded');
    await page.getByRole('textbox', { name: 'Email address' }).fill('lyrafaiqb@gmail.com');
    await page.getByRole('textbox', { name: 'Password' }).fill('#Tiaranac31');
    await page.getByRole('button', { name: 'Sign In' }).click();
    await page.waitForLoadState('networkidle');
  }

  // ── Hit URL filter dengan brand yang tidak ada ────────────────────────
  await page.goto(
    'http://127.0.0.1:8000/catalog?brand=BrandTidakAdaXYZ999&sort=newest',
    { waitUntil: 'domcontentloaded' }
  );
  await page.waitForLoadState('networkidle');

  // ── Verifikasi empty state muncul ─────────────────────────────────────
  const emptyState = page.locator('.cat-empty');
  await expect(emptyState).toBeVisible({ timeout: 10000 });

  // Sesuai blade yang sudah diupdate
  await expect(emptyState).toContainText('Produk tidak ditemukan');
  await expect(emptyState).toContainText('Coba ubah filter atau kata kunci pencarian');

  // ── Verifikasi tidak ada product card ────────────────────────────────
  await expect(page.locator('.cat-product-card')).toHaveCount(0);

  // ── Verifikasi sort bar "No products found" ───────────────────────────
  await expect(page.getByText('No products found')).toBeVisible();
});