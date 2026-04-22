from playwright.sync_api import Page, expect, sync_playwright
import os
import re

def capture_view(page: Page, url_path: str, name: str):
    try:
        full_url = f"http://localhost:8000{url_path}"
        print(f"Navigating to {full_url}...")
        page.goto(full_url)
        page.wait_for_load_state("networkidle")
        os.makedirs("verification", exist_ok=True)
        screenshot_path = f"verification/{name}.png"
        page.screenshot(path=screenshot_path)
        print(f"Successfully captured {screenshot_path}.")
    except Exception as e:
        print(f"Error capturing {name}: {e}")

def test_views(page: Page):
    # 1. Capture Login Page
    capture_view(page, "/", "login_page")

    # Verify we are on login page
    expect(page.locator('input[name="user"]')).to_be_visible()

    # 2. Login
    try:
        print("Attempting login...")
        page.fill('input[name="user"]', "admin")
        page.fill('input[name="pass"]', "secret")
        page.click('input[type="submit"]')
        page.wait_for_load_state("networkidle")
    except Exception as e:
        print(f"Login failed: {e}")

    # 3. Capture Post-Login Views
    # Home page
    capture_view(page, "/index.php", "home_page_logged_in")
    expect(page).to_have_title(re.compile("ADDRESS_BOOK|Address Book"))

    # Edit page
    capture_view(page, "/edit.php", "edit_page")
    # Check for text in the page, using the actual rendered text
    expect(page.locator('body')).to_contain_text("EDIT_ADD_ENTRY")

    # Groups page
    capture_view(page, "/group.php", "groups_page")
    expect(page.locator('body')).to_contain_text("GROUPS")

    # Birthdays page
    capture_view(page, "/birthdays.php", "birthdays_page")
    expect(page.locator('body')).to_contain_text("NEXT_BIRTHDAYS")

    # View page (print view or similar)
    capture_view(page, "/view.php", "view_page")
    expect(page.locator('body')).to_contain_text("PRINT_ALL")

if __name__ == "__main__":
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        # Use a consistent viewport size
        context = browser.new_context(viewport={'width': 1280, 'height': 800})
        page = context.new_page()
        try:
            test_views(page)
        finally:
            browser.close()
