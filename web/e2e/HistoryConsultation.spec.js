import { test, expect } from '@playwright/test';

test('History Consultation', async ({ page }) => {
  test.setTimeout(120000);

  // ── Login ──────────────────────────────────────────────────────────────
  await page.goto('http://127.0.0.1:8000/');
  await page.getByRole('link', { name: 'Login' }).click();

  await page.getByRole('textbox', { name: 'Email address' }).fill('lyrafaiqb@gmail.com');
  await page.getByRole('textbox', { name: 'Password' }).fill('#Tiaranac31');
  await page.getByRole('button', { name: 'Sign In' }).click();

  await page.waitForLoadState('networkidle');

  // ── Navigasi ke Profile ────────────────────────────────────────────────
  await page.goto('http://127.0.0.1:8000/profile', { waitUntil: 'domcontentloaded' });

  // ── Klik history item ──────────────────────────────────────────────────
  const historyItem = page.getByText('19 Jun 2026').first();
  await expect(historyItem).toBeVisible({ timeout: 15000 });
  await historyItem.click();

  // ── Verifikasi modal muncul ────────────────────────────────────────────
  const modalOverlay = page.locator('#detailModalOverlay');
  const modal        = page.locator('.pf-modal');

  await expect(modalOverlay).toBeVisible({ timeout: 10000 });
  await expect(modal).toBeVisible({ timeout: 10000 });

  // ── Verifikasi konten modal ────────────────────────────────────────────
  await expect(modal.locator('.pf-modal-title')).toBeVisible();
  await expect(modal.locator('.pf-modal-date')).toContainText('19 Jun 2026');

  // ── Tutup modal ────────────────────────────────────────────────────────
  await modal.locator('.pf-modal-close').click();
  await expect(modalOverlay).toBeHidden({ timeout: 5000 });
});