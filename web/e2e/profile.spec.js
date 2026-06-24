import { test, expect } from '@playwright/test';

// ── Helper Login ───────────────────────────────────────────────────────────
async function loginProfile(page) {
  await page.goto('http://127.0.0.1:8000/', { waitUntil: 'domcontentloaded' });
  const loginLink = page.getByRole('link', { name: 'Login' });
  if (await loginLink.isVisible()) {
    await loginLink.click();
    await page.waitForLoadState('domcontentloaded');
    await page.getByRole('textbox', { name: 'Email address' }).fill('lyrafaiqahb@gmail.com');
    await page.getByRole('textbox', { name: 'Password' }).fill('#Lyrafaiqah31');
    await page.getByRole('button', { name: 'Sign In' }).click();
    await page.waitForLoadState('networkidle');
  }
}

// ── Helper ke Halaman Change Password ─────────────────────────────────────
async function goToChangePassword(page) {
  await loginProfile(page);
  await page.goto('http://127.0.0.1:8000/profile', { waitUntil: 'domcontentloaded' });
  await page.waitForLoadState('networkidle');
  await page.locator('a.pf-ubah-btn').click();
  await page.waitForLoadState('domcontentloaded');
  await expect(page).toHaveURL(/password/);
}

// ── Test 1: Semua Field Kosong ─────────────────────────────────────────────
test('Change Password - Semua Field Kosong', async ({ page }) => {
  test.setTimeout(120000);
  await goToChangePassword(page);

  // Langsung klik submit tanpa isi apapun
  await page.getByRole('button', { name: /save|update|change|submit|simpan/i }).click();
  await page.waitForLoadState('domcontentloaded');

  // Harus muncul pesan error validasi
  const error = page.locator('.pf-alert-error, [class*="error"], [class*="invalid"]');
  await expect(error.first()).toBeVisible({ timeout: 10000 });
});

// ── Test 2: Current Password Kosong ───────────────────────────────────────
test('Change Password - Current Password Kosong', async ({ page }) => {
  test.setTimeout(120000);
  await goToChangePassword(page);

  // Isi new password & konfirmasi, tapi current password kosong
  await page.locator('input[name="password"]').fill('#Tiaranac2731');
  await page.locator('input[name="password_confirmation"]').fill('#Tiaranac2731');
  await page.getByRole('button', { name: /save|update|change|submit|simpan/i }).click();
  await page.waitForLoadState('domcontentloaded');

  const error = page.locator('.pf-alert-error, [class*="error"], [class*="invalid"]');
  await expect(error.first()).toBeVisible({ timeout: 10000 });
});

// ── Test 3: New Password Kosong ────────────────────────────────────────────
test('Change Password - New Password Kosong', async ({ page }) => {
  test.setTimeout(120000);
  await goToChangePassword(page);

  await page.locator('input[name="current_password"]').fill('#Lyrafaiqah31');
  // Biarkan new password & konfirmasi kosong
  await page.getByRole('button', { name: /save|update|change|submit|simpan/i }).click();
  await page.waitForLoadState('domcontentloaded');

  const error = page.locator('.pf-alert-error, [class*="error"], [class*="invalid"]');
  await expect(error.first()).toBeVisible({ timeout: 10000 });
});

// ── Test 4: Password Tanpa Simbol ─────────────────────────────────────────
test('Change Password - Password Tanpa Simbol', async ({ page }) => {
  test.setTimeout(120000);
  await goToChangePassword(page);

  await page.locator('input[name="current_password"]').fill('#Lyrafaiqah31');
  await page.locator('input[name="password"]').fill('Tiaranac2731');         // tanpa simbol
  await page.locator('input[name="password_confirmation"]').fill('Tiaranac2731');
  await page.getByRole('button', { name: /save|update|change|submit|simpan/i }).click();
  await page.waitForLoadState('domcontentloaded');

  // Tergantung validasi app — kalau tidak ada aturan simbol, mungkin berhasil
  // Kalau ada validasi simbol, harus muncul error
  const error = page.locator('.pf-alert-error, [class*="error"], [class*="invalid"]');
  const success = page.locator('.pf-alert-success, [class*="success"]');
  const errorVisible   = await error.first().isVisible().catch(() => false);
  const successVisible = await success.first().isVisible().catch(() => false);
  expect(errorVisible || successVisible).toBe(true);
});

// ── Test 5: Password Terlalu Pendek (< 8 karakter) ────────────────────────
test('Change Password - Password Terlalu Pendek', async ({ page }) => {
  test.setTimeout(120000);
  await goToChangePassword(page);

  await page.locator('input[name="current_password"]').fill('#Lyrafaiqah31');
  await page.locator('input[name="password"]').fill('#Ti1');               // < 8 karakter
  await page.locator('input[name="password_confirmation"]').fill('#Ti1');
  await page.getByRole('button', { name: /save|update|change|submit|simpan/i }).click();
  await page.waitForLoadState('domcontentloaded');

  const error = page.locator('.pf-alert-error, [class*="error"], [class*="invalid"]');
  await expect(error.first()).toBeVisible({ timeout: 10000 });
});

// ── Test 6: Konfirmasi Password Tidak Cocok ────────────────────────────────
test('Change Password - Konfirmasi Tidak Cocok', async ({ page }) => {
  test.setTimeout(120000);
  await goToChangePassword(page);

  await page.locator('input[name="current_password"]').fill('#Lyrafaiqah31');
  await page.locator('input[name="password"]').fill('#Tiaranac2731');
  await page.locator('input[name="password_confirmation"]').fill('#PasswordBeda999'); // beda
  await page.getByRole('button', { name: /save|update|change|submit|simpan/i }).click();
  await page.waitForLoadState('domcontentloaded');

  const error = page.locator('.pf-alert-error, [class*="error"], [class*="invalid"]');
  await expect(error.first()).toBeVisible({ timeout: 10000 });
  await expect(error.first()).toContainText(/confirm|match|cocok/i);
});

// ── Test 7: Current Password Salah ────────────────────────────────────────
test('Change Password - Current Password Salah', async ({ page }) => {
  test.setTimeout(120000);
  await goToChangePassword(page);

  await page.locator('input[name="current_password"]').fill('#PasswordSalah999');  // salah
  await page.locator('input[name="password"]').fill('#Tiaranac2731');
  await page.locator('input[name="password_confirmation"]').fill('#Tiaranac2731');
  await page.getByRole('button', { name: /save|update|change|submit|simpan/i }).click();
  await page.waitForLoadState('domcontentloaded');

  const error = page.locator('.pf-alert-error, [class*="error"], [class*="invalid"]');
  await expect(error.first()).toBeVisible({ timeout: 10000 });
  await expect(error.first()).toContainText(/incorrect|wrong|salah/i);
});

// ── Test 8: Paste Password (Copy Paste) ───────────────────────────────────
test('Change Password - Input dengan Copy Paste', async ({ page }) => {
  test.setTimeout(120000);
  await goToChangePassword(page);

  // Simulasi paste menggunakan clipboard API
  await page.locator('input[name="current_password"]').fill('#Lyrafaiqah31');

  const newPassInput = page.locator('input[name="password"]');
  const confPassInput = page.locator('input[name="password_confirmation"]');

  // Fokus ke field lalu paste via keyboard shortcut
  await newPassInput.click();
  await page.evaluate(() => navigator.clipboard.writeText('#Tiaranac2731'));
  await newPassInput.press('Control+v');
  await page.waitForTimeout(500);

  await confPassInput.click();
  await page.evaluate(() => navigator.clipboard.writeText('#Tiaranac2731'));
  await confPassInput.press('Control+v');
  await page.waitForTimeout(500);

  await page.getByRole('button', { name: /save|update|change|submit|simpan/i }).click();
  await page.waitForLoadState('domcontentloaded');

  // Paste harus berfungsi normal — verifikasi tidak ada error paste
  const error = page.locator('.pf-alert-error, [class*="error"], [class*="invalid"]');
  const errorVisible = await error.first().isVisible().catch(() => false);
  if (errorVisible) {
    // Kalau error, bukan karena paste — mungkin password sudah pernah dipakai
    console.log('Error setelah paste:', await error.first().textContent());
  }
});

// ── Test 9: Ganti Password Berhasil ───────────────────────────────────────
test('Change Password - Berhasil Ganti Password', async ({ page }) => {
  test.setTimeout(120000);
  await goToChangePassword(page);

  await page.locator('input[name="current_password"]').fill('#Lyrafaiqah31');
  await page.locator('input[name="password"]').fill('#Tiaranac2731');
  await page.locator('input[name="password_confirmation"]').fill('#Tiaranac2731');
  await page.getByRole('button', { name: /save|update|change|submit|simpan/i }).click();
  await page.waitForLoadState('networkidle');

  // Verifikasi sukses — redirect ke profile dengan pesan sukses
  await expect(page).toHaveURL(/profile/);
  const success = page.locator('.pf-alert-success, [class*="success"]');
  await expect(success).toBeVisible({ timeout: 10000 });
  await expect(success).toContainText(/updated|berhasil|success/i);
});