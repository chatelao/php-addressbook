# Goal

PHP Address Book provides a web-based interface for maintaining an address book, organizing contacts into groups, and synchronizing with various devices.

# Structure

- `CONCEPT.md`: Business Cases with 1:N Use Cases each, High-level business architecture, and the Roadmap.
- `PRODUCT_SUMMARY.md`: Overview of the application, key features, technical stack, and page index.
- `TECHNICAL_DEBTS.md`: Log of architectural or implementation debts, including a library version audit.
- `/test/`: Test suite, including unit tests and regression tests.

# ROADMAP rules
- The roadmap is located in `CONCEPT.md` and is automatically managed by the `Jules Automation` workflow.
- Implement only modest, feasible and reasonable steps in one go.
  - If no such steps available, alternatively break down bigger steps to modest ones without implementing anything, just changing the Roadmap itself.

# HOWTO

- Keep `src/install.sh` to install all tools and dependencies.

# Testing Locally & with Github Action Workflow

- Maintain a CI/CD pipeline that runs on every commit and every push.
- Use `test/install.sh` to install testing-specific dependencies.
- Add caching to the Github action workflows to speed up builds.
- When working on tasks from the roadmap, always **execute from bottom to top**.
- New tasks are added to the top of the list.
- Tasks are marked as completed with a timestamp and the corresponding issue id when the issue is closed.
