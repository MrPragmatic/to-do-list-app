import { test, expect } from '@playwright/test';

test('login', async ({ page }) => {
  // Navigate to the login page
  await page.goto('http://localhost:8000/login.php');

  // Fill in the login form
  await page.fill('input[name=username]', 'test9@test.com');
  await page.fill('input[name=password]', 'testpassword');
  await page.click('button[type=submit]');

  // Wait for registration to complete (adjust as needed)
  await page.waitForTimeout(2000);

  // Assert that the user has logged in successfully
  expect(page.url()).toBe('http://localhost:8000/taskspace.php');
});