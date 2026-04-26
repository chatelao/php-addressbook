# Goal

<summarize the existing solution in one sentence>

# Structure

- `CONCEPT.md`: Business Cases with 1:N Use Cases each as well as a High-level business architecture
- `DESIGN.md` : Detailed design of the application (<tbd>) and the chosen tech stack (<tbd>).
- `ROADMAP.md`: Task tracking for the transpiler development, organized by chapters, 
- `TECHNICAL_DEBTS.md`: Log of architectural or implementation debts.
- `WEBFOCUS_TO_POSTGRE.md`: The core strategy and technical reasoning for the migration target.
- `/specifications/`: External documentation and manuals converted to Markdown.
- `/src/`: Transpiler source code (<tbd>).
- `/test/`: Test suite, including real-world WebFOCUS samples and regression tests.

# ROADMAP rules
- The `ROADMAP.md` is automatically managed by the `Jules Automation` workflow.
- Implement only modest, feasible and reasonable steps in one go
  - If no such steps available, alternativly break down bigger steps to modest ones without implementing anything, just changing the Roadmap itself.

# HOWTO

- Keep `src/install.sh` to install all tools and dependencies (<tbd>).

# Testing Locally & with Github Action Workflow

- Maintain a CI/CD pipeline that runs on every commit and every push.
- Use `test/install.sh` to install testing-specific dependencies.
- Add caching to the Github action workflows to speed up builds.
- When working on tasks from the `ROADMAP.md`, always **execute from bottom to top**.
- New tasks are added to the top of the list.
- Tasks are marked as completed with a timestamp and the corresponding issue id when the issue is closed.
