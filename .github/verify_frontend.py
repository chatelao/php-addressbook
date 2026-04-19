from playwright.sync_api import Page, expect, sync_playwright
import os
import re

def test_home_page(page: Page):
    try:
        page.goto("http://localhost:8000")
        page.wait_for_load_state("networkidle")
        os.makedirs("verification", exist_ok=True)
        page.screenshot(path="verification/home_page.png")
        # Basic assertion - checking for title or some text
        # Actual value seen in previous run was "ADDRESS_BOOK"
        expect(page).to_have_title(re.compile("ADDRESS_BOOK|Address Book"))
        print("Successfully captured home_page.png and verified title.")
    except Exception as e:
        print(f"Error capturing screenshot or asserting title: {e}")
        # Even if it fails, we might want to see what's there
        try:
            page.screenshot(path="verification/error_page.png")
        except:
            pass
        exit(1)

if __name__ == "__main__":
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()
        try:
            test_home_page(page)
        finally:
            browser.close()
