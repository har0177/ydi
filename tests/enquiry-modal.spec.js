// @ts-check
const { test, expect } = require('@playwright/test');

const BASE_URL = 'http://localhost/ydi-all/public_html';

test.describe('Enquire Now modal', () => {

  test('opens from a trainings.php card with the correct service pre-filled', async ({ page }) => {
    await page.goto(`${BASE_URL}/trainings.php`);

    // Click the first "Enquire Now" button (Teachers' Development card)
    await page.getByRole('button', { name: /Enquire Now/i }).first().click();

    // Modal heading
    await expect(page.getByRole('heading', { name: 'Enquire Now' })).toBeVisible();

    // Service field is pre-filled (editable so users can override or add detail)
    const serviceField = page.locator('#enquireServiceField');
    await expect(serviceField).toBeVisible();
    await expect(serviceField).toHaveValue("Teachers' Development");
  });

  test('opens from the global floating Enquire button with empty service', async ({ page }) => {
    await page.goto(`${BASE_URL}/index.php`);

    // The floating button has just the text "Enquire" (no card "Enquire Now")
    await page.getByRole('button', { name: 'Enquire', exact: true }).click();

    await expect(page.getByRole('heading', { name: 'Enquire Now' })).toBeVisible();

    // Service field is empty and editable from the global trigger
    const serviceField = page.locator('#enquireServiceField');
    await expect(serviceField).toBeVisible();
    await expect(serviceField).toHaveValue('');
    await serviceField.fill('IELTS Training');
    await expect(serviceField).toHaveValue('IELTS Training');
  });

  test('closes when the close button is clicked', async ({ page }) => {
    await page.goto(`${BASE_URL}/trainings.php`);
    await page.getByRole('button', { name: /Enquire Now/i }).first().click();
    await expect(page.locator('#enquireServiceField')).toBeVisible();

    await page.getByRole('button', { name: 'Close' }).click();
    await expect(page.locator('#enquireServiceField')).toBeHidden();
  });

  test('closes when ESC is pressed', async ({ page }) => {
    await page.goto(`${BASE_URL}/trainings.php`);
    await page.getByRole('button', { name: /Enquire Now/i }).first().click();
    await expect(page.locator('#enquireServiceField')).toBeVisible();

    await page.keyboard.press('Escape');
    await expect(page.locator('#enquireServiceField')).toBeHidden();
  });

  test('submits successfully and shows the thank-you message', async ({ page }) => {
    await page.goto(`${BASE_URL}/trainings.php`);
    await page.getByRole('button', { name: /Enquire Now/i }).first().click();

    await page.locator('#enquireName').fill('Playwright Tester');
    await page.locator('#enquirePhone').fill('+92 300 1234567');
    await page.locator('#enquireEmail').fill('playwright@example.com');
    await page.locator('#enquireMessage').fill('This is an automated test enquiry. Please disregard.');

    await page.getByRole('button', { name: /Submit Enquiry/i }).click();

    // Success panel
    const success = page.locator('[data-test="enquiry-success"]');
    await expect(success).toBeVisible({ timeout: 10000 });
    await expect(success).toContainText('Thank you for contacting us. Our customer service team will get back to you soon.');
  });

  test('shows an inline error when submitting with invalid phone', async ({ page }) => {
    await page.goto(`${BASE_URL}/trainings.php`);
    await page.getByRole('button', { name: /Enquire Now/i }).first().click();

    // Bypass the HTML5 pattern check by removing the attribute, so the request reaches the server
    await page.locator('#enquirePhone').evaluate(el => el.removeAttribute('pattern'));

    await page.locator('#enquireName').fill('Bad Phone Tester');
    await page.locator('#enquirePhone').fill('not-a-phone');
    await page.locator('#enquireEmail').fill('bad@example.com');
    await page.locator('#enquireMessage').fill('Triggering server-side phone validation.');

    await page.getByRole('button', { name: /Submit Enquiry/i }).click();

    await expect(page.getByText('Invalid phone number')).toBeVisible({ timeout: 10000 });
  });
});
