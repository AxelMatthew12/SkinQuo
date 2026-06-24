import { test, expect } from '@playwright/test';

// ── Helper Login ────────────────────────────────────────────────────────────
async function login(page) {
  await page.goto('http://127.0.0.1:8000/', { waitUntil: 'domcontentloaded' });
  const loginLink = page.getByRole('link', { name: 'Login' });
  if (await loginLink.isVisible()) {
    await loginLink.click();
    await page.waitForLoadState('domcontentloaded');
    await page.getByRole('textbox', { name: 'Email address' }).fill('lyrafaiqb@gmail.com');
    await page.getByRole('textbox', { name: 'Password' }).fill('#Tiaranac31');
    await page.getByRole('button', { name: 'Sign In' }).click();
    await page.waitForLoadState('networkidle');
  }
}

// ── Test 1: List artikel tampil ─────────────────────────────────────────────
test('Skin Guide - List Artikel Tampil', async ({ page }) => {
  test.setTimeout(120000);
  await login(page);

  await page.goto('http://127.0.0.1:8000/skin-guide', { waitUntil: 'domcontentloaded' });
  await page.waitForLoadState('networkidle');

  // Verifikasi halaman terbuka
  await expect(page).toHaveURL(/skin-guide/);
  await expect(page.locator('.sg-hero-title')).toBeVisible({ timeout: 10000 });

  // Verifikasi featured article atau grid artikel muncul
  const featuredOrGrid = page.locator('.sg-grid, .sg-featured, [class*="rounded-[32px]"]');
  await expect(featuredOrGrid.first()).toBeVisible({ timeout: 10000 });

  // Verifikasi filter category muncul
  await expect(page.locator('.sg-filters')).toBeVisible();
});

// ── Test 2: Search artikel valid ────────────────────────────────────────────
test('Skin Guide - Search Artikel Valid', async ({ page }) => {
  test.setTimeout(120000);
  await login(page);

  await page.goto('http://127.0.0.1:8000/skin-guide', { waitUntil: 'domcontentloaded' });

  const searchInput = page.locator('#sg-search');
  await expect(searchInput).toBeVisible({ timeout: 10000 });

  // Ketik keyword valid
  await searchInput.fill('skin');
  await page.waitForURL(/search=skin/, { timeout: 15000 });
  await page.waitForLoadState('networkidle');

  // Verifikasi URL berubah
  await expect(page).toHaveURL(/search=skin/);

  // Verifikasi tidak muncul empty state (ada hasil)
  await expect(page.locator('.sg-empty')).not.toBeVisible();
});

// ── Test 3: Search artikel tidak ditemukan ──────────────────────────────────
test('Skin Guide - Search Tidak Ditemukan', async ({ page }) => {
  test.setTimeout(120000);
  await login(page);

  await page.goto(
    'http://127.0.0.1:8000/skin-guide?search=artikelyangtidakadaxyz999',
    { waitUntil: 'domcontentloaded' }
  );
  await page.waitForLoadState('networkidle');

  // Verifikasi empty state muncul
  const emptyState = page.locator('.sg-empty');
  await expect(emptyState).toBeVisible({ timeout: 10000 });
  await expect(emptyState).toContainText('Tidak ada artikel yang cocok dengan kata kunci');
  await expect(emptyState).toContainText('artikelyangtidakadaxyz999');
});

// ── Test 4: Filter by category ──────────────────────────────────────────────
test('Skin Guide - Filter Kategori', async ({ page }) => {
  test.setTimeout(120000);
  await login(page);

  await page.goto('http://127.0.0.1:8000/skin-guide', { waitUntil: 'domcontentloaded' });
  await page.waitForLoadState('networkidle');

  // Ambil tombol kategori pertama (selain "All")
  const categoryBtns = page.locator('.sg-filter-btn');
  const count = await categoryBtns.count();

  // Minimal ada tombol "All"
  expect(count).toBeGreaterThan(0);

  if (count > 1) {
    // Klik kategori pertama setelah "All"
    const firstCategoryBtn = categoryBtns.nth(1);
    const categoryName = await firstCategoryBtn.textContent();
    await firstCategoryBtn.click();

    await page.waitForURL(/category=/, { timeout: 15000 });
    await page.waitForLoadState('networkidle');

    // Verifikasi URL mengandung category
    await expect(page).toHaveURL(/category=/);

    // Verifikasi tombol aktif
    await expect(firstCategoryBtn).toHaveClass(/active/);
  }
});

// ── Test 5: Detail artikel tampil ───────────────────────────────────────────
test('Skin Guide - Detail Artikel Tampil', async ({ page }) => {
  test.setTimeout(120000);
  await login(page);

  await page.goto('http://127.0.0.1:8000/skin-guide', { waitUntil: 'domcontentloaded' });
  await page.waitForLoadState('networkidle');

  // Klik featured article (link pertama yang menuju skin-guide/{slug})
  const articleLink = page.locator('a[href*="/skin-guide/"]').first();
  await expect(articleLink).toBeVisible({ timeout: 10000 });

  const href = await articleLink.getAttribute('href');
  await articleLink.click();
  await page.waitForLoadState('domcontentloaded');

  // Verifikasi URL berubah ke detail artikel
  await expect(page).toHaveURL(/\/skin-guide\/.+/);

  // Verifikasi konten artikel muncul (judul dan isi)
  await expect(page.locator('h1, h2, [class*="title"]').first()).toBeVisible({ timeout: 10000 });
});