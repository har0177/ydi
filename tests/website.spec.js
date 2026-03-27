// @ts-check
const { test, expect } = require('@playwright/test');

const BASE_URL = 'http://localhost/ydi-all/public_html';

test.describe('YDI Public Website Tests', () => {

  test('Homepage loads successfully', async ({ page }) => {
    const response = await page.goto(`${BASE_URL}/index.php`);

    // Check page loads with 200 status
    expect(response.status()).toBe(200);

    // Check title
    await expect(page).toHaveTitle(/YDI/i);

    // Check main elements exist
    await expect(page.locator('.navbar')).toBeVisible();
    await expect(page.locator('.main-wrapper')).toBeVisible();
  });

  test('No JavaScript console errors on homepage', async ({ page }) => {
    const consoleErrors = [];

    page.on('console', msg => {
      if (msg.type() === 'error') {
        consoleErrors.push(msg.text());
      }
    });

    await page.goto(`${BASE_URL}/index.php`);
    await page.waitForLoadState('networkidle');

    // Filter out known acceptable errors (like external resources)
    const criticalErrors = consoleErrors.filter(err =>
      !err.includes('favicon') &&
      !err.includes('404') &&
      !err.includes('net::ERR') &&
      !err.includes('Failed to load resource')
    );

    expect(criticalErrors).toHaveLength(0);
  });

  test('Bootstrap 5 navbar is functional', async ({ page }) => {
    await page.goto(`${BASE_URL}/index.php`);

    // Check navbar elements
    await expect(page.locator('.navbar-brand')).toBeVisible();
    await expect(page.locator('.navbar-toggler')).toBeAttached();

    // Check navigation links exist
    const navLinks = page.locator('.navbar-nav .nav-link, .navbar-nav .nav-item a');
    const count = await navLinks.count();
    expect(count).toBeGreaterThan(0);
  });

  test('Theme toggle button exists and works', async ({ page }) => {
    await page.goto(`${BASE_URL}/index.php`);

    // Find theme toggle button
    const themeToggle = page.locator('#themeToggle');
    await expect(themeToggle).toBeAttached();

    // Get initial theme
    const initialTheme = await page.locator('html').getAttribute('data-theme');

    // Click toggle
    await themeToggle.click();

    // Wait for theme change
    await page.waitForTimeout(500);

    // Get new theme
    const newTheme = await page.locator('html').getAttribute('data-theme');

    // Theme should have changed
    expect(newTheme).not.toBe(initialTheme);

    // Toggle back
    await themeToggle.click();
    await page.waitForTimeout(500);

    const revertedTheme = await page.locator('html').getAttribute('data-theme');
    expect(revertedTheme).toBe(initialTheme);
  });

  test('Theme persists on page reload', async ({ page }) => {
    await page.goto(`${BASE_URL}/index.php`);

    // Set dark theme
    const themeToggle = page.locator('#themeToggle');
    const initialTheme = await page.locator('html').getAttribute('data-theme');

    if (initialTheme === 'light') {
      await themeToggle.click();
      await page.waitForTimeout(500);
    }

    // Verify dark theme
    await expect(page.locator('html')).toHaveAttribute('data-theme', 'dark');

    // Reload page
    await page.reload();
    await page.waitForLoadState('networkidle');

    // Theme should persist
    await expect(page.locator('html')).toHaveAttribute('data-theme', 'dark');

    // Clean up - switch back to light
    await page.locator('#themeToggle').click();
  });

  test('Contact form has CSRF token', async ({ page }) => {
    await page.goto(`${BASE_URL}/index.php`);

    // Look for CSRF token in contact form (in footer)
    const csrfToken = page.locator('form input[name="csrf_token"]');
    await expect(csrfToken).toBeAttached();

    // Token should have a value
    const tokenValue = await csrfToken.getAttribute('value');
    expect(tokenValue).toBeTruthy();
    expect(tokenValue.length).toBeGreaterThan(20);
  });

  test('jQuery 3.x is loaded', async ({ page }) => {
    await page.goto(`${BASE_URL}/index.php`);
    await page.waitForLoadState('networkidle');

    // Check jQuery version
    const jQueryVersion = await page.evaluate(() => {
      if (typeof jQuery !== 'undefined') {
        return jQuery.fn.jquery;
      }
      return null;
    });

    expect(jQueryVersion).not.toBeNull();
    expect(jQueryVersion).toMatch(/^3\./);
  });

  test('Bootstrap 5 is loaded', async ({ page }) => {
    await page.goto(`${BASE_URL}/index.php`);
    await page.waitForLoadState('networkidle');

    // Check Bootstrap version
    const bootstrapLoaded = await page.evaluate(() => {
      return typeof bootstrap !== 'undefined';
    });

    expect(bootstrapLoaded).toBe(true);
  });

  test('CSS custom properties are applied', async ({ page }) => {
    await page.goto(`${BASE_URL}/index.php`);

    // Check that CSS variables are defined
    const bgBody = await page.evaluate(() => {
      return getComputedStyle(document.documentElement).getPropertyValue('--bg-body').trim();
    });

    expect(bgBody).toBeTruthy();
  });

  test('Dark mode applies correct styles', async ({ page }) => {
    await page.goto(`${BASE_URL}/index.php`);

    // Get light mode background
    const lightBg = await page.evaluate(() => {
      return getComputedStyle(document.documentElement).getPropertyValue('--bg-body').trim();
    });

    // Switch to dark mode
    await page.locator('#themeToggle').click();
    await page.waitForTimeout(500);

    // Get dark mode background
    const darkBg = await page.evaluate(() => {
      return getComputedStyle(document.documentElement).getPropertyValue('--bg-body').trim();
    });

    // Colors should be different
    expect(darkBg).not.toBe(lightBg);
    expect(darkBg).toContain('#121212');

    // Clean up
    await page.locator('#themeToggle').click();
  });

  test('Carousel controls work with Bootstrap 5', async ({ page }) => {
    await page.goto(`${BASE_URL}/index.php`);

    // Check if carousels exist
    const carousel = page.locator('.carousel').first();

    if (await carousel.isVisible()) {
      // Check Bootstrap 5 data attributes
      const dataRide = await carousel.getAttribute('data-bs-ride');
      expect(dataRide).toBe('carousel');

      // Check controls
      const nextBtn = carousel.locator('.carousel-control-next, [data-bs-slide="next"]');
      const prevBtn = carousel.locator('.carousel-control-prev, [data-bs-slide="prev"]');

      await expect(nextBtn).toBeAttached();
      await expect(prevBtn).toBeAttached();
    }
  });

  test('Mobile navbar toggle works', async ({ page }) => {
    // Set mobile viewport
    await page.setViewportSize({ width: 375, height: 667 });
    await page.goto(`${BASE_URL}/index.php`);

    // Navbar toggler should be visible on mobile
    const toggler = page.locator('.navbar-toggler');
    await expect(toggler).toBeVisible();

    // Click toggler
    await toggler.click();
    await page.waitForTimeout(500);

    // Nav should expand
    const navCollapse = page.locator('.navbar-collapse');
    await expect(navCollapse).toHaveClass(/show/);
  });

  test('Footer renders correctly', async ({ page }) => {
    await page.goto(`${BASE_URL}/index.php`);

    // Scroll to footer
    await page.locator('footer').scrollIntoViewIfNeeded();

    // Check footer elements
    await expect(page.locator('footer')).toBeVisible();
    await expect(page.locator('.copyRight')).toBeVisible();

    // Check social links
    const socialLinks = page.locator('footer .list-inline-item');
    const count = await socialLinks.count();
    expect(count).toBeGreaterThan(0);
  });

  test('Back to top button appears on scroll', async ({ page }) => {
    await page.goto(`${BASE_URL}/index.php`);

    const backToTop = page.locator('#backToTop');

    // Initially should have low opacity
    await page.waitForTimeout(500);

    // Scroll down
    await page.evaluate(() => window.scrollTo(0, 500));
    await page.waitForTimeout(500);

    // Button should be visible now
    const opacity = await backToTop.evaluate(el =>
      window.getComputedStyle(el).opacity
    );
    expect(parseFloat(opacity)).toBe(1);
  });

});

test.describe('Quiz Page Tests', () => {

  test('Quiz page loads without errors', async ({ page }) => {
    const consoleErrors = [];

    page.on('console', msg => {
      if (msg.type() === 'error') {
        consoleErrors.push(msg.text());
      }
    });

    const response = await page.goto(`${BASE_URL}/quiz.php`);

    if (response.status() === 200) {
      await page.waitForLoadState('networkidle');

      const criticalErrors = consoleErrors.filter(err =>
        !err.includes('favicon') &&
        !err.includes('404') &&
        !err.includes('net::ERR') &&
        !err.includes('Failed to load resource')
      );

      expect(criticalErrors).toHaveLength(0);
    }
  });

});

test.describe('Security Tests', () => {

  test('No PHP errors displayed', async ({ page }) => {
    await page.goto(`${BASE_URL}/index.php`);

    const pageContent = await page.content();

    // Check for common PHP error indicators
    expect(pageContent).not.toContain('Fatal error');
    expect(pageContent).not.toContain('Parse error');
    expect(pageContent).not.toContain('Warning:');
    expect(pageContent).not.toContain('Notice:');
    expect(pageContent).not.toContain('Deprecated:');
  });

  test('Error reporting is disabled in production', async ({ page }) => {
    await page.goto(`${BASE_URL}/index.php`);

    const pageContent = await page.content();

    // Should not expose stack traces
    expect(pageContent).not.toContain('Stack trace');
    expect(pageContent).not.toContain('in /var/www');
    expect(pageContent).not.toContain('in C:\\');
  });

});
