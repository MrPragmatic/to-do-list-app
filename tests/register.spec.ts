import { test, expect } from '@playwright/test';

test('register', async ({ page }) => {
  // Navigate to the registration page
  await page.goto('http://localhost:8000/register.php');

  // Fill in the registration form
  await page.fill('input[name=username]', 'test9@test.com');
  await page.fill('input[name=password]', 'testpassword');
  await page.fill('input[name=confirm_password]', 'testpassword');
  await page.click('button[type=submit]');

  // Wait for registration to complete (adjust as needed)
  await page.waitForTimeout(2000);

  // Assert that the user is registered successfully
  expect(page.url()).toBe('http://localhost:8000/login.php');
});
